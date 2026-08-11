<?php

namespace App\Http\Controllers;

use App\Http\Repositories\ReporteRepository;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReporteController extends Controller
{
    protected $reporteRepository;

    public function __construct(ReporteRepository $reporteRepository) {
        $this->reporteRepository = $reporteRepository;
    }

    public function consultasPorPeriodo(Request $request) {
        try {
            $reporte = $this->reporteRepository->consultasPorPeriodo(
                $request->query("fecha_inicio"),
                $request->query("fecha_fin"),
                $request->query("veterinario_id"),
                $request->query("especie")
            );
            return response()->json($reporte,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function motivosFrecuentes(Request $request) {
        try {
            $reporte = $this->reporteRepository->motivosFrecuentes(
                $request->query("fecha_inicio"),
                $request->query("fecha_fin"),
                $request->query("veterinario_id")
            );
            return response()->json($reporte,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function vacunasPorVencer(Request $request) {
        try {
            $reporte = $this->reporteRepository->vacunasPorVencer($request->query("especie"));
            return response()->json($reporte,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function medicamentosStockBajo() {
        try {
            $reporte = $this->reporteRepository->medicamentosStockBajo();
            return response()->json($reporte,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function resumenDelDia(Request $request) {
        try {
            $reporte = $this->reporteRepository->resumenDelDia($request->query("fecha"));
            return response()->json($reporte,200);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function medicamentosStockBajoPdf() {
        try {
            $reporte = $this->reporteRepository->medicamentosStockBajo();

            $pdf = Pdf::loadView("reportes.medicamentos_stock_bajo", [
                "medicamentos" => $reporte["data"]
            ]);

            return $pdf->download("medicamentos-stock-bajo.pdf");
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function resumenDelDiaPdf(Request $request) {
        try {
            $reporte = $this->reporteRepository->resumenDelDia($request->query("fecha"));

            $pdf = Pdf::loadView("reportes.resumen_del_dia", [
                "fecha" => $reporte["fecha"],
                "data" => $reporte["data"]
            ]);

            return $pdf->download("resumen-del-dia.pdf");
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function consultasPorPeriodoPdf(Request $request) {
        try {
            $reporte = $this->reporteRepository->consultasPorPeriodo(
                $request->query("fecha_inicio"),
                $request->query("fecha_fin"),
                $request->query("veterinario_id"),
                $request->query("especie")
            );

            $pdf = Pdf::loadView("reportes.consultas_por_periodo", [
                "por_veterinario" => $reporte["por_veterinario"],
                "por_especie" => $reporte["por_especie"]
            ]);

            return $pdf->download("consultas-por-periodo.pdf");
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function motivosFrecuentesPdf(Request $request) {
        try {
            $reporte = $this->reporteRepository->motivosFrecuentes(
                $request->query("fecha_inicio"),
                $request->query("fecha_fin"),
                $request->query("veterinario_id")
            );

            $pdf = Pdf::loadView("reportes.motivos_frecuentes", [
                "motivos" => $reporte["data"]
            ]);

            return $pdf->download("motivos-frecuentes.pdf");
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function vacunasPorVencerPdf(Request $request) {
        try {
            $reporte = $this->reporteRepository->vacunasPorVencer($request->query("especie"));

            $pdf = Pdf::loadView("reportes.vacunas_por_vencer", [
                "vacunas" => $reporte["data"]
            ]);

            return $pdf->download("vacunas-por-vencer.pdf");
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function medicamentosStockBajoExcel() {
        try {
            $reporte = $this->reporteRepository->medicamentosStockBajo();

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue("A1", "Nombre");
            $sheet->setCellValue("B1", "Tipo");
            $sheet->setCellValue("C1", "Cantidad Actual");
            $sheet->setCellValue("D1", "Cantidad Minima");
            $sheet->getStyle("A1:D1")->getFont()->setBold(true);

            $fila = 2;
            foreach ($reporte["data"] as $medicamento) {
                $sheet->setCellValue("A" . $fila, $medicamento->nombre);
                $sheet->setCellValue("B" . $fila, $medicamento->tipo);
                $sheet->setCellValue("C" . $fila, $medicamento->cantidad_actual);
                $sheet->setCellValue("D" . $fila, $medicamento->cantidad_minima_alerta);
                $fila++;
            }

            $writer = new Xlsx($spreadsheet);

            return response()->streamDownload(function () use ($writer) {
                $writer->save("php://output");
            }, "medicamentos-stock-bajo.xlsx", [
                "Content-Type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            ]);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function resumenDelDiaExcel(Request $request) {
        try {
            $reporte = $this->reporteRepository->resumenDelDia($request->query("fecha"));

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue("A1", "Estado");
            $sheet->setCellValue("B1", "Total");
            $sheet->getStyle("A1:B1")->getFont()->setBold(true);

            $filas = [
                "Agendadas" => $reporte["data"]["agendadas"],
                "Confirmadas" => $reporte["data"]["confirmadas"],
                "En consulta" => $reporte["data"]["en_consulta"],
                "Completadas" => $reporte["data"]["completadas"],
                "Canceladas" => $reporte["data"]["canceladas"],
            ];

            $fila = 2;
            foreach ($filas as $estado => $total) {
                $sheet->setCellValue("A" . $fila, $estado);
                $sheet->setCellValue("B" . $fila, $total);
                $fila++;
            }

            $writer = new Xlsx($spreadsheet);
            return response()->streamDownload(function () use ($writer) {
                $writer->save("php://output");
            }, "resumen-del-dia.xlsx", [
                "Content-Type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            ]);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function motivosFrecuentesExcel(Request $request) {
        try {
            $reporte = $this->reporteRepository->motivosFrecuentes(
                $request->query("fecha_inicio"), $request->query("fecha_fin"), $request->query("veterinario_id")
            );

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue("A1", "Motivo");
            $sheet->setCellValue("B1", "Total");
            $sheet->getStyle("A1:B1")->getFont()->setBold(true);

            $fila = 2;
            foreach ($reporte["data"] as $item) {
                $sheet->setCellValue("A" . $fila, $item->motivo);
                $sheet->setCellValue("B" . $fila, $item->total);
                $fila++;
            }

            $writer = new Xlsx($spreadsheet);
            return response()->streamDownload(function () use ($writer) {
                $writer->save("php://output");
            }, "motivos-frecuentes.xlsx", [
                "Content-Type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            ]);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function vacunasPorVencerExcel(Request $request) {
        try {
            $reporte = $this->reporteRepository->vacunasPorVencer($request->query("especie"));

            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue("A1", "Mascota");
            $sheet->setCellValue("B1", "Especie");
            $sheet->setCellValue("C1", "Vacuna");
            $sheet->setCellValue("D1", "Proxima Dosis");
            $sheet->getStyle("A1:D1")->getFont()->setBold(true);

            $fila = 2;
            foreach ($reporte["data"] as $vacuna) {
                $sheet->setCellValue("A" . $fila, $vacuna->mascota->nombre);
                $sheet->setCellValue("B" . $fila, $vacuna->mascota->especie);
                $sheet->setCellValue("C" . $fila, $vacuna->nombre_vacuna);
                $sheet->setCellValue("D" . $fila, $vacuna->fecha_proxima_dosis->format("d/m/Y"));
                $fila++;
            }

            $writer = new Xlsx($spreadsheet);
            return response()->streamDownload(function () use ($writer) {
                $writer->save("php://output");
            }, "vacunas-por-vencer.xlsx", [
                "Content-Type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            ]);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }

    public function consultasPorPeriodoExcel(Request $request) {
        try {
            $reporte = $this->reporteRepository->consultasPorPeriodo(
                $request->query("fecha_inicio"), $request->query("fecha_fin"),
                $request->query("veterinario_id"), $request->query("especie")
            );

            $spreadsheet = new Spreadsheet();

            $hoja1 = $spreadsheet->getActiveSheet();
            $hoja1->setTitle("Por Veterinario");
            $hoja1->setCellValue("A1", "Veterinario");
            $hoja1->setCellValue("B1", "Total");
            $hoja1->getStyle("A1:B1")->getFont()->setBold(true);
            $fila = 2;
            foreach ($reporte["por_veterinario"] as $item) {
                $hoja1->setCellValue("A" . $fila, $item->veterinario);
                $hoja1->setCellValue("B" . $fila, $item->total);
                $fila++;
            }

            $hoja2 = $spreadsheet->createSheet();
            $hoja2->setTitle("Por Especie");
            $hoja2->setCellValue("A1", "Especie");
            $hoja2->setCellValue("B1", "Total");
            $hoja2->getStyle("A1:B1")->getFont()->setBold(true);
            $fila = 2;
            foreach ($reporte["por_especie"] as $item) {
                $hoja2->setCellValue("A" . $fila, $item->especie);
                $hoja2->setCellValue("B" . $fila, $item->total);
                $fila++;
            }

            $writer = new Xlsx($spreadsheet);
            return response()->streamDownload(function () use ($writer) {
                $writer->save("php://output");
            }, "consultas-por-periodo.xlsx", [
                "Content-Type" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
            ]);
        }
        catch (\Exception $e) {
            return response()->json(["mensaje" => $e -> getMessage()],500);
        }
    }
}
