    <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class ArchivoConsulta extends Model
    {
        protected $table = 'archivos_consulta';

        public $timestamps = false;

        protected $fillable = [
            'consulta_id',
            'nombre_archivo',
            'ruta_archivo',
            'tipo',
        ];

        public function consulta()
        {
            return $this->belongsTo(Consulta::class);
        }
    }
