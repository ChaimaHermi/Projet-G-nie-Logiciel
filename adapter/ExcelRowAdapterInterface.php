
<!-- Target (interface) -->

<?php


interface ExcelRowAdapterInterface
{
    /**
     * Convertit une ligne Excel brute en tableau de données compatible avec le modèle Laravel.
     *
     * @return array|null
     */
    public function convert(): ?array;
}
