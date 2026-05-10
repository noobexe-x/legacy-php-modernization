output "instance_id" {
  value = aws_instance.app.id
}

output "instance_arn" {
  value = aws_instance.app.arn
}

output "app_security_group_id" {
  value = aws_security_group.app.id
}
