<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230712152814 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create rates table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<SQL
            CREATE TABLE rates (
                id                BIGSERIAL                      NOT NULL PRIMARY KEY,
                created_at        TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT current_timestamp(0),
                updated_at        TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL DEFAULT current_timestamp(0),
                dt                TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
                base_currency     TEXT                           NOT NULL,
                quote_currency    TEXT                           NOT NULL,
                factor            NUMERIC(28, 8)                 NOT NULL CHECK ( factor > 0.0 ),
                CONSTRAINT rates_bc_qc_key UNIQUE (base_currency, quote_currency)
            )
        SQL);
        $this->addSql('CREATE TRIGGER updated_at_trigger BEFORE UPDATE ON rates FOR EACH ROW EXECUTE PROCEDURE refresh_updated_at();');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE rates');
    }
}
