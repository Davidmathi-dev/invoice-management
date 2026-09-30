<?php

namespace App\Services;

class InvoiceCalculationService
{
    /**
     * Calculate invoice items and totals.
     * @param array $items Array of ['quantity' => x, 'unit_price' => y, 'discount' => z, 'tax_rate' => w]
     * @return array
     */
    public function calculate(array $items)
    {
        $calculatedItems = [];
        $invoiceSubtotal = 0;
        $invoiceDiscount = 0;
        $invoiceTax = 0;

        foreach ($items as $item) {
            $qty = (float)($item['quantity'] ?? 0);
            $price = (float)($item['unit_price'] ?? 0);
            $discount = (float)($item['discount'] ?? 0);
            $taxRate = (float)($item['tax_rate'] ?? 0);

            $itemSubtotal = $qty * $price;
            $taxableAmount = $itemSubtotal - $discount;
            if ($taxableAmount < 0) {
                $taxableAmount = 0;
            }

            $itemTax = $taxableAmount * ($taxRate / 100);
            $itemTotal = $taxableAmount + $itemTax;

            $calculatedItems[] = array_merge($item, [
                'subtotal' => $itemSubtotal,
                'discount' => $discount,
                'tax' => $itemTax,
                'total' => $itemTotal,
            ]);

            $invoiceSubtotal += $itemSubtotal;
            $invoiceDiscount += $discount;
            $invoiceTax += $itemTax;
        }

        $grandTotal = $invoiceSubtotal - $invoiceDiscount + $invoiceTax;

        return [
            'items' => $calculatedItems,
            'subtotal' => $invoiceSubtotal,
            'discount' => $invoiceDiscount,
            'tax' => $invoiceTax,
            'total' => $grandTotal,
        ];
    }
}
