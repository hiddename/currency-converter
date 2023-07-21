<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230712152805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create function refresh_updated_at()';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE OR REPLACE FUNCTION refresh_updated_at() RETURNS TRIGGER AS $$
            BEGIN
                NEW.updated_at = current_timestamp(0);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP FUNCTION IF EXISTS refresh_updated_at();');
    }
}
