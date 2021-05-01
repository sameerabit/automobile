<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobCard extends Model
{
    protected $fillable = [
        'vehicle_id',
        'date',
        'booking_id',
    ];

    public function details()
    {
        return $this->hasMany(JobCardDetail::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function sales()
    {
        return $this->hasMany(JobSale::class);
    }

    public function totalServicePrice(){
        return $this->details()->sum('actual_cost');
    }

    public function totalSales(){
        $total = 0;
        foreach($this->sales as $sale) {
            $total += ($sale->quantity - $sale->return_qty) * $sale->price;
        }
        return $total;
    }

    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function paidAmount(){
        return $this->payments()->sum('amount');
    }

    public function paymentStatus()
    {
        return $this->payments->sum('amount') < ($this->totalSales() + $this->totalServicePrice());
    }
}
