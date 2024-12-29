<?php
include 'koneksi.php';
ob_start();

require('fpdf/fpdf.php');

class PDF extends FPDF
{
    protected $widths;
    protected $aligns;

    function SetWidths($w)
    {
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        $this->aligns = $a;
    }

    function WriteTableRow($data, $imageFile = '', $imageHeight = 0)
    {
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }

        // Ubah ini: tambahkan padding dan pastikan tinggi baris cukup untuk gambar
        $padding = 4; // padding atas dan bawah
        $minHeight = $imageHeight + (2 * $padding); // tinggi minimum untuk menampung gambar
        $textHeight = 5 * $nb; // tinggi untuk teks

        // Gunakan yang lebih besar antara tinggi teks atau tinggi gambar
        $h = max($minHeight, $textHeight);

        $this->CheckPageBreak($h);

        // Draw the cells of the row
        $startX = $this->GetX();
        $startY = $this->GetY();

        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();

            // Draw the border
            $this->Rect($x, $y, $w, $h);

            // Print the text
            if ($i == 2 && $imageFile && file_exists($imageFile)) { // Column for image
                // Dapatkan dimensi gambar asli
                list($originalWidth, $originalHeight) = getimagesize($imageFile);

                // Hitung rasio aspek
                $ratio = $originalWidth / $originalHeight;

                // Tentukan lebar maksimum dalam kolom (misalnya 80% dari lebar kolom)
                $maxWidth = $w * 0.8;

                // Hitung dimensi yang proporsional
                if ($ratio > 1) {
                    // Gambar landscape
                    $newWidth = min($maxWidth, $imageHeight * $ratio);
                    $newHeight = $newWidth / $ratio;
                } else {
                    // Gambar portrait atau square
                    $newHeight = $imageHeight;
                    $newWidth = $newHeight * $ratio;
                }

                // Posisikan gambar di tengah kolom
                $xPos = $x + ($w - $newWidth) / 2;
                $yPos = $y + ($h - $newHeight) / 2;

                // Tampilkan gambar dengan dimensi yang sudah dihitung
                $this->Image($imageFile, $xPos, $yPos, $newWidth, $newHeight);
                // $this->Image($imageFile, $x + ($w / 2) - ($imageHeight / 2), $y + 2, $imageHeight, $imageHeight);
            } else {
                $this->MultiCell($w, 5, $data[$i], 0, $a);
            }

            // Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }

        $this->Ln($h);
    }

    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;

        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;

        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;

        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    function CheckPageBreak($h)
    {
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AddPage();

// Header
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(190, 7, 'DAFTAR DESTINASI WISATA', 1, 1, 'C');


$pdf->Cell(10, 7, '', 0, 1);
$pdf->SetFont('Arial', 'B', 10);

// Set column widths
$pdf->SetWidths(array(55, 80, 55));
$pdf->SetAligns(array('L', 'L', 'C'));

// Header tabel
$pdf->Cell(55, 6, 'NAMA DESTINASI', 1, 0, 'C');
$pdf->Cell(80, 6, 'DESKRIPSI', 1, 0, 'C');
$pdf->Cell(55, 6, 'GAMBAR', 1, 1, 'C');
$pdf->SetFont('Arial', '', 10);

// Image settings
$imageHeight = 35;

// Fetch and display data
$destinasi = mysqli_query($con, "SELECT * FROM destinasi");
while ($row = mysqli_fetch_array($destinasi)) {
    $data = array(
        $row['nama_destinasi'],
        strip_tags($row['deskripsi']), // Remove HTML tags from description
        ''  // Empty string for image column
    );
    $pdf->WriteTableRow($data, $row['gambar'], $imageHeight);
}

$pdf->Output('I', 'daftar_destinasi.pdf');
ob_end_flush();
