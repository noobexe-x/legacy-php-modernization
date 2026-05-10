output "vpc_id" {
  value = module.network.vpc_id
}

output "alb_dns_name" {
  value = module.alb.alb_dns_name
}

output "ec2_instance_id" {
  value       = module.ec2.instance_id
  description = "Session Manager / aws ec2 start-instances 用"
}

output "route53_fqdn" {
  value       = length(module.route53) > 0 ? module.route53[0].fqdn : null
  description = "create_route53_record が true のときの FQDN"
}

output "rds_endpoint" {
  value     = module.rds.db_endpoint
  sensitive = false
}

output "rds_port" {
  value = module.rds.db_port
}

output "s3_bucket_id" {
  value = module.s3.bucket_id
}

output "db_password" {
  value       = random_password.db.result
  sensitive   = true
  description = "RDS マスターパスワード（初回のみ表示推奨・Secrets Manager 移行推奨）"
}

output "cloudwatch_log_groups" {
  value = module.monitoring.log_group_names
}

output "backup_vault_name" {
  value = var.backup_plan_enabled ? module.backup[0].vault_name : null
}
