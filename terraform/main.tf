# メイン：各モジュールをここで呼び出し（ネットワーク → コンピュート → DNS / 監視 / バックアップ）
provider "aws" {
  region = var.aws_region

  default_tags {
    tags = {
      Project     = var.project_name
      Environment = var.environment
      ManagedBy   = "terraform"
    }
  }
}

check "route53_domain_when_dns_enabled" {
  assert {
    condition     = !var.create_route53_record || length(trimspace(var.domain_name)) > 0
    error_message = "create_route53_record が true のときは domain_name に既存のパブリックホストゾーン名を設定してください。"
  }
}

resource "random_password" "db" {
  length  = 16
  special = false
}

# --- ネットワーク ---
module "network" {
  source = "./modules/network"

  project_name = var.project_name
  environment  = var.environment
  vpc_cidr     = var.vpc_cidr
}

# --- S3（アプリアセット・バックアップ用バケット等）---
module "s3" {
  source = "./modules/s3"

  project_name = var.project_name
  environment  = var.environment
}

# --- ALB（セキュリティグループ含む。EC2 より先に SG ID が必要）---
module "alb" {
  source = "./modules/alb"

  project_name      = var.project_name
  environment       = var.environment
  vpc_id            = module.network.vpc_id
  public_subnet_ids = module.network.public_subnet_ids
}

# --- EC2（プライベートサブネット、アプリサーバー）---
module "ec2" {
  source = "./modules/ec2"

  project_name            = var.project_name
  environment             = var.environment
  vpc_id                  = module.network.vpc_id
  private_subnet_ids      = module.network.private_subnet_ids
  instance_type           = var.ec2_instance_type
  alb_security_group_id   = module.alb.alb_security_group_id

  depends_on = [module.alb]
}

# --- RDS（MySQL）---
module "rds" {
  source = "./modules/rds"

  project_name            = var.project_name
  environment             = var.environment
  vpc_id                  = module.network.vpc_id
  private_subnet_ids      = module.network.private_subnet_ids
  ec2_security_group_id   = module.ec2.app_security_group_id
  db_name                 = var.db_name
  db_username             = var.db_username
  db_password             = random_password.db.result
  instance_class          = var.rds_instance_class
  allocated_storage       = var.rds_allocated_storage
  backup_retention_period = var.rds_backup_retention_days
  deletion_protection     = var.enable_deletion_protection

  depends_on = [module.ec2]
}

# --- ALB → EC2 ターゲット紐付け ---
resource "aws_lb_target_group_attachment" "app" {
  target_group_arn = module.alb.target_group_arn
  target_id        = module.ec2.instance_id
  port             = 80
}

# --- Route53（既存ホストゾーンに ALB エイリアス）※ false のときはモジュール自体を読まない ---
module "route53" {
  count  = var.create_route53_record ? 1 : 0
  source = "./modules/route53"

  domain_name  = var.domain_name
  record_name  = var.route53_record_name
  alb_dns_name = module.alb.alb_dns_name
  alb_zone_id  = module.alb.alb_zone_id
}

# --- CloudWatch（ロググループ・アラーム）---
module "monitoring" {
  source = "./modules/monitoring"

  project_name            = var.project_name
  environment             = var.environment
  alb_arn_suffix          = module.alb.alb_arn_suffix
  target_group_arn_suffix = module.alb.target_group_arn_suffix
  rds_id                  = module.rds.db_instance_id
}

# --- AWS Backup（RDS + EC2 のコピー）---
module "backup" {
  count  = var.backup_plan_enabled ? 1 : 0
  source = "./modules/backup"

  project_name            = var.project_name
  environment             = var.environment
  schedule_cron           = var.backup_schedule_cron
  delete_after_days       = var.backup_delete_after_days
  protected_resource_arns = [module.rds.db_instance_arn, module.ec2.instance_arn]

  depends_on = [module.rds, module.ec2]
}
