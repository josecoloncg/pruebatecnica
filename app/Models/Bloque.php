<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bloque extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre_bloque',
        'proyecto_id',
        'descripcion',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'proyecto_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the proyecto that owns the bloque.
     */
    public function proyecto(): BelongsTo
    {
        return $this->belongsTo(Proyecto::class);
    }

    /**
     * Get the piezas for the bloque.
     */
    public function piezas(): HasMany
    {
        return $this->hasMany(Pieza::class);
    }

    /**
     * Get piezas pendientes del bloque.
     */
    public function piezasPendientes(): HasMany
    {
        return $this->hasMany(Pieza::class)->where('estado', 'Pendiente');
    }

    /**
     * Get piezas fabricadas del bloque.
     */
    public function piezasFabricadas(): HasMany
    {
        return $this->hasMany(Pieza::class)->where('estado', 'Fabricado');
    }

    /**
     * Scope para filtrar por proyecto.
     */
    public function scopeByProyecto($query, int $proyectoId)
    {
        return $query->where('proyecto_id', $proyectoId);
    }

    /**
     * Get formatted bloque identifier (IDBloque-NombreBloque).
     */
    public function getIdentificadorAttribute(): string
    {
        return "{$this->proyecto_id}-{$this->nombre_bloque}";
    }
}
