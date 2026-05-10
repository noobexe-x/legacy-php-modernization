output "log_group_names" {
  value = [
    aws_cloudwatch_log_group.app.name,
    aws_cloudwatch_log_group.nginx.name,
  ]
}
