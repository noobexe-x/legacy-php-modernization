output "fqdn" {
  value       = aws_route53_record.app.fqdn
  description = "作成したレコードの FQDN"
}
