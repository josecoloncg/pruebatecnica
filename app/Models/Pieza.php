<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pieza extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'pieza',
        'peso_teorico',
        'peso_real',
        'estado',
        'proyecto_id',
        'bloque_id',
        'fecha_registro',
        'registrado_por',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'peso_teorico' => 'decimal:2',
        'peso_real' => 'decimal:2',
        'proyecto_id' => 'integer',
        'bloque_id' => 'integer',
        'registrado_por' => 'integer',
        'fecha_registro' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the proyecto that owns the pieza.
     */
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    /**
     * Get the bloque that owns the pieza.
     */
    public function bloque(): BelongsTo
    {
        return $this->belongsTo(Bloque::class);
    }

    /**
     * Get the user that registered the pieza.
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }

    /**
     * Calculate the difference between theoretical and real weight.
     */
    public function getDiferenciaPesoAttribute(): ?float
    {
        if ($this->peso_real === null) {
            return null;
        }
        
        return round($this->peso_real - $this->peso_teorico, 2);
    }

    /**
     * Scope para filtrar por estado.
     */
    public function scopePendientes($query)
    {
        return $query->where('estado', 'Pendiente');
    }

    /**
     * Scope para filtrar fabricadas.
     */
    public function scopeFabricadas($query)
    {
        return $query->where('estado', 'Fabricado');
    }

    /**
     * Scope para filtrar por bloque.
     */
    public function scopeByBloque($query, int $bloqueId)
    {
        return $query->where('bloque_id', $bloqueId);
    }

    /**
     * Scope para filtrar por proyecto.
     */
    public function scopeByProyecto($query, int $proyectoId)
    {
        return $query->where('proyecto_id', $proyectoId);
    }

    /**
     * Mark pieza as fabricado with real weight.
     */
    public function marcarComoFabricado(float $pesoReal, int $usuarioId): bool
    {
        $this->peso_real = $pesoReal;
        $this->estado = 'Fabricado';
        $this->fecha_registro = now();
        $this->registrado_por = $usuarioId;
        
        return $this->save();
    }
}
