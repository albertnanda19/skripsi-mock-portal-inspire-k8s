#!/bin/bash

echo "Rolling back all migrations..."
php spark migrate:rollback

echo "All migrations have been rolled back."

