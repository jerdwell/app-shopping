<?php namespace LoftonTi\Quotations\Models;

use Model;

/**
 * Model
 */
class Quotations extends Model
{
    use \October\Rain\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'loftonti_quotations_quotations';
    public $fillable = [
        'items',
        'amount',
        'status',
        'shipping_address',
        'shipping_date',
        'shipping_contact',
        'branch',
        'created_at',
        'updated_at'
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * methods
     */

    public static function setDataContactQuotation($data)
    {
        $data_contact_quotation = [
            [
                'item' => 'Nombre',
                'value' => $data -> firstname . ' ' . $data -> lastname,
            ],
            [
                'item' => 'Correo',
                'value' => $data -> email,
            ],
            [
                'item' => 'Teléfono',
                'value' => $data -> phone,
            ],
        ];
        return $data_contact_quotation;
    }

    public static function SetDataQuotationAddress($data)
    {
        $data_address_quotation = [
            [
                'item' => 'Calle y número',
                'value' => $data -> address1
            ],
            [
                'item' => 'Colonia',
                'value' => $data -> suburb
            ],
            [
                'item' => 'Código postal',
                'value' => $data -> zip_code
            ],
            [
                'item' => 'Ciudad',
                'value' => $data -> city
            ],
            [
                'item' => 'Delegación/Municipo',
                'value' => $data -> country
            ],
            [
                'item' => 'Estado',
                'value' => $data -> state
            ],
        ];
        return $data_address_quotation;
    }

}
