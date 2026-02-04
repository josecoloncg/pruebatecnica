<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proyecto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the bloques for the proyecto.
     */
    public function bloques(): HasMany
    {
        return $this->hasMany(Bloque::class);
    }

    /**
     * Get the piezas for the proyecto.
     */
    public function piezas(): HasMany
    {
        return $this->hasMany(Pieza::class);
    }

    /**
     * Get piezas pendientes del proyecto.
     */
    public function piezasPendientes(): HasMany
    {
        return $this->hasMany(Pieza::class)->where('estado', 'Pendiente');
    }

    /**
     * Get piezas fabricadas del proyecto.
     */
    public function piezasFabricadas(): HasMany
    {
        return $this->hasMany(Pieza::class)->where('estado', 'Fabricado');
    }

    /**
     * Scope para buscar por código.
     */
    public function scopeByCodigo($query, string $codigo)
    {
        return $query->where('codigo', $codigo);
    }
}
