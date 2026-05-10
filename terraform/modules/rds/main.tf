# MySQL RDS（プライベートサブネット、アプリ SG から 3306 のみ）
resource "aws_db_subnet_group" "this" {
  name       = "${var.project_name}-${var.environment}-db-subnet"
  subnet_ids = var.private_subnet_ids

  tags = {
    Name = "${var.project_name}-${var.environment}-db-subnet"
  }
}

resource "aws_security_group" "db" {
  name        = "${var.project_name}-${var.environment}-rds-sg"
  description = "RDS MySQL"
  vpc_id      = var.vpc_id

  ingress {
    description     = "MySQL from app"
    from_port       = 3306
    to_port         = 3306
    protocol        = "tcp"
    security_groups = [var.ec2_security_group_id]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }

  tags = {
    Name = "${var.project_name}-${var.environment}-rds-sg"
  }
}

resource "aws_db_instance" "this" {
  identifier                 = "${var.project_name}-${var.environment}-mysql"
  engine                     = "mysql"
  engine_version             = "8.0"
  instance_class             = var.instance_class
  allocated_storage          = var.allocated_storage
  storage_type               = "gp3"
  db_name                    = var.db_name
  username                   = var.db_username
  password                   = var.db_password
  db_subnet_group_name       = aws_db_subnet_group.this.name
  vpc_security_group_ids     = [aws_security_group.db.id]
  multi_az                   = false
  publicly_accessible        = false
  backup_retention_period    = var.backup_retention_period
  backup_window              = "18:00-19:00"
  maintenance_window         = "Mon:19:00-Mon:20:00"
  skip_final_snapshot        = !var.deletion_protection
  deletion_protection        = var.deletion_protection
  auto_minor_version_upgrade = true
  storage_encrypted          = true

  tags = {
    Name = "${var.project_name}-${var.environment}-mysql"
  }
}
