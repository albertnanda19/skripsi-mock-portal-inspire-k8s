migrate-down:
	@echo "Executing migration rollback..."
	@./scripts/migrate_down.sh

migrate-and-seed:
	@echo "Running migrations and seeders..."
	@./scripts/run_migrations_and_seeders.sh

