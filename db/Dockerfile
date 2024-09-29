# Use the official MariaDB image as the base
FROM mariadb:latest

# Force cache invalidation by adding an arbitrary environment variable
ENV CACHEBUST=1

# Install the MariaDB client and symlink it to 'mysql'
RUN apt-get update && apt-get install -y --reinstall mariadb-client \
    && ln -s /usr/bin/mariadb /usr/bin/mysql  # Create a symlink for mysql command

# Set the working directory to the MariaDB data directory
WORKDIR /var/lib/mysql

# Expose MariaDB's default port
EXPOSE 3306
