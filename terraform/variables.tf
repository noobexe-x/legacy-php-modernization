# 共通変数
variable "aws_region" {
  description = "AWS リージョン（東京）"
  type        = string
  default     = "ap-northeast-1"
}

variable "project_name" {
  description = "リソース名プレフィックス"
  type        = string
  default     = "laravel-pos"
}

variable "environment" {
  description = "環境識別子（例: dev, staging, prod）"
  type        = string
  default     = "dev"
}

variable "vpc_cidr" {
  description = "VPC CIDR"
  type        = string
  default     = "10.40.0.0/16"
}

variable "domain_name" {
  description = "create_route53_record が true のとき必須。Route53 に既存のパブリックホストゾーン名（例: example.com）。テストのみなら false のまま空でよい。"
  type        = string
  default     = ""
}

variable "create_route53_record" {
  description = "ALB への A エイリアスレコードを作成するか（テストは false で ALB DNS を利用）"
  type        = bool
  default     = false
}

variable "route53_record_name" {
  description = "ドメインからの相対名（例: app → app.example.com）"
  type        = string
  default     = "app"
}

variable "ec2_instance_type" {
  type    = string
  default = "t3.small"
}

variable "rds_instance_class" {
  type    = string
  default = "db.t3.micro"
}

variable "rds_allocated_storage" {
  type    = number
  default = 20
}

variable "db_name" {
  type    = string
  default = "laravel"
}

variable "db_username" {
  type    = string
  default = "laravel"
}

variable "rds_backup_retention_days" {
  description = "RDS 自動スナップショット保持日数（0 で無効）"
  type        = number
  default     = 7
}

variable "backup_plan_enabled" {
  description = "AWS Backup（RDS + EC2）を有効にする"
  type        = bool
  default     = true
}

variable "backup_schedule_cron" {
  description = "AWS Backup スケジュール（UTC cron）"
  type        = string
  default     = "cron(0 18 * * ? *)" # 毎日 03:00 JST 相当（概算）
}

variable "backup_delete_after_days" {
  type    = number
  default = 14
}

variable "enable_deletion_protection" {
  description = "RDS / ALB の削除保護（本番向け）"
  type        = bool
  default     = false
}
