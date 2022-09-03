<?php

class BooksTab
{
    private const TABLE_START = "<table class='table'>";
    private const TABLE_END = "</table>";
    private string $tableHTML = self::TABLE_START;

    public function finishTable(): string
    {
        $this->tableHTML .= self::TABLE_END;
        return $this->tableHTML;
    }

    public function addHeader(array $fieldnames)
    {
        $this->tableHTML .= "<thead><tr>";
        foreach ($fieldnames as $fieldname)
            $this->tableHTML .= "<th scope='col'>" . $fieldname . "</th>";
        $this->tableHTML .= "</tr></thead>";
    }
    public function generateElements(array $rows)
    {
        $this->tableHTML .= "<tbody>";
        foreach ($rows as $row) :
            $this->tableHTML .= "<tr>";
            foreach ($row as $elementValue) :
                $this->tableHTML .= "<td>";
                $this->tableHTML .= $elementValue;
                $this->tableHTML .= "</td>";
            endforeach;
            $this->tableHTML .= "</tr>";

        endforeach;
        $this->tableHTML .= "</tbody>";
    }
};