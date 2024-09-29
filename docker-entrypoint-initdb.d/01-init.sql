-- Create corp_cache table
CREATE TABLE IF NOT EXISTS corp_cache (
    corporation_id BIGINT PRIMARY KEY,
    name VARCHAR(255),
    ticker VARCHAR(10),
    date_founded DATE,
    timestamp DATETIME
);
