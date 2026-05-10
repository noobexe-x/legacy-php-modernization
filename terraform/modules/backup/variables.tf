variable "project_name" { type = string }
variable "environment" { type = string }
variable "schedule_cron" { type = string }
variable "delete_after_days" { type = number }
variable "protected_resource_arns" { type = list(string) }
