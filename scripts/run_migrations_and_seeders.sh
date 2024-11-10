echo "Running migrations..."
php spark migrate

echo "Running seeders..."
php spark db:seed RoleSeeder
php spark db:seed UserSeeder
php spark db:seed CourseSeeder
php spark db:seed CourseLecturerSeeder
php spark db:seed EnrollmentsSeeder

echo "Migrations and seeders have been executed successfully."