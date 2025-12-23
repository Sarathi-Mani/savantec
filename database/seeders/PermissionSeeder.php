<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            // Users Module
            'user_view',
            'user_add', 
            'user_edit',
            'user_delete',
            
            // Roles Module
            'role_view',
            'role_add',
            'role_edit', 
            'role_delete',
            
            // Tax Module
            'tax_view',
            'tax_add',
            'tax_edit',
            'tax_delete',
            
            // Units Module
            'unit_view',
            'unit_add',
            'unit_edit',
            'unit_delete',
            
            // Payment Types Module
            'payment_type_view',
            'payment_type_add',
            'payment_type_edit',
            'payment_type_delete',
            
            // Company Module
            'company_view',
            'company_add',
            'company_edit',
            'company_delete',
            
            // Store Module
            'store_view',
            'store_edit',
            
            // Dashboard Module
            'dashboard_view',
            'dashboard_info1',
            'dashboard_info2',
            'dashboard_chart',
            'dashboard_items',
            'dashboard_stock_alert',
            'dashboard_trending',
            'dashboard_recent_sales',
            
            // Accounts Module
            'account_view',
            'account_add',
            'account_edit',
            'account_delete',
            'money_deposit_view',
            'money_deposit_add',
            'money_deposit_edit',
            'money_deposit_delete',
            'cash_flow_view',
            'cash_flow_add',
            'cash_flow_edit',
            'cash_flow_delete',
            'money_transfer_view',
            'money_transfer_add',
            'money_transfer_edit',
            'money_transfer_delete',
            'chart_of_accounts_view',
            'chart_of_accounts_add',
            'chart_of_accounts_edit',
            'chart_of_accounts_delete',
            'entries_view',
            'entries_add',
            'entries_edit',
            'entries_delete',
            'cash_transactions',
            
            // Expense Module
            'expense_view',
            'expense_add',
            'expense_edit',
            'expense_delete',
            'expense_category_view',
            'expense_category_add',
            'expense_category_edit',
            'expense_category_delete',
            'expense_item_view',
            'expense_item_add',
            'expense_item_edit',
            'expense_item_delete',
            'show_all_users_expenses',
            
            // Items Module
            'item_view',
            'item_add',
            'item_edit',
            'item_delete',
            'item_category_view',
            'item_category_add',
            'item_category_edit',
            'item_category_delete',
            'print_labels',
            'import_items',
            
            // Stock Transfer Module
            'stock_transfer_view',
            'stock_transfer_add',
            'stock_transfer_edit',
            'stock_transfer_delete',
            
            // Stock Journal Module
            'stock_journal_view',
            'stock_journal_add',
            'stock_journal_edit',
            'stock_journal_delete',
            
            // Stock Adjustment Module
            'stock_adjustment_view',
            'stock_adjustment_add',
            'stock_adjustment_edit',
            'stock_adjustment_delete',
            
            // Brand Module
            'brand_view',
            'brand_add',
            'brand_edit',
            'brand_delete',
            
            // Variant Module
            'variant_view',
            'variant_add',
            'variant_edit',
            'variant_delete',
            
            // Suppliers Module
            'supplier_view',
            'supplier_add',
            'supplier_edit',
            'supplier_delete',
            'import_suppliers',
            
            'enquiry_view',
            'enquiry_add',
            'enquiry_edit',
            'enquiry_delete',
            'enquiry_report',

            'view enquiry',      // With space
            'create enquiry',    // With space
            'edit enquiry',      // With space
            'delete enquiry',    // With space
            'manage enquiry',

            // Customers Module
            'customer_view',
            'customer_add',
            'customer_edit',
            'customer_delete',
            'import_customers',
            
            // Customers Advance Payments Module
            'customer_advance_view',
            'customer_advance_add',
            'customer_advance_edit',
            'customer_advance_delete',
            
            // Supplier Advance Payments Module
            'supplier_advance_view',
            'supplier_advance_add',
            'supplier_advance_edit',
            'supplier_advance_delete',
            
            // Purchase Module
            'purchase_view',
            'purchase_add',
            'purchase_edit',
            'purchase_delete',
            'purchase_payments_view',
            'purchase_payments_add',
            'purchase_payments_delete',
            'show_all_users_purchase_invoices',
            
            // Purchase Order Module
            'purchase_order_view',
            'purchase_order_add',
            'purchase_order_edit',
            'purchase_order_delete',
            
            // Purchase Return Module
            'purchase_return_view',
            'purchase_return_add',
            'purchase_return_edit',
            'purchase_return_delete',
            'purchase_return_payments_view',
            'purchase_return_payments_add',
            'purchase_return_payments_delete',
            'show_all_users_purchase_return_invoices',
            
            // Sales Module
            'sales_view',
            'sales_add',
            'sales_edit',
            'sales_delete',
            'sales_payments_view',
            'sales_payments_add',
            'sales_payments_delete',
            'show_all_users_sales_invoices',
            'show_item_purchase_price',
            
            // Proforma Invoice Module
            'proforma_invoice_view',
            'proforma_invoice_add',
            'proforma_invoice_edit',
            'proforma_invoice_delete',
            
            // Delivery Challan In Module
            'delivery_challan_in_view',
            'delivery_challan_in_add',
            'delivery_challan_in_edit',
            'delivery_challan_in_delete',
            
            // Delivery Challan Out Module
            'delivery_challan_out_view',
            'delivery_challan_out_add',
            'delivery_challan_out_edit',
            'delivery_challan_out_delete',
            
            // Salesorder Module
            'salesorder_view',
            'salesorder_add',
            'salesorder_edit',
            'salesorder_delete',
            
            // Discount Coupon Module
            'discount_coupon_view',
            'discount_coupon_add',
            'discount_coupon_edit',
            'discount_coupon_delete',
            
            // Quotation Module
            'quotation_view',
            'quotation_add',
            'quotation_edit',
            'quotation_delete',
            'print quotation',
            'convert quotation',
            'convert to delivery challan',
             'show all users quotations',
            'show_all_users_quotations',
            
            // Sales Return Module
            'sales_return_view',
            'sales_return_add',
            'sales_return_edit',
            'sales_return_delete',
            'sales_return_payments_view',
            'sales_return_payments_add',
            'sales_return_payments_delete',
            'show_all_users_sales_return_invoices',
            
            // Reports Module (Add all report permissions from your form)
            'report_delivery_sheet',
            'report_load_sheet',
            'report_customer_orders',
            'report_customer',
            'report_supplier',
            'report_sales_tax',
            'report_purchase_tax',
            'report_supplier_items',
            'report_sales',
            'report_sales_register',
            'report_purchase_register',
            'report_sales_return',
            'report_seller_points',
            'report_purchase',
            'report_overseas_ledger',
            'report_purchase_return',
            'report_expense',
            'report_expense_outstanding',
            'report_expense_payment',
            'report_expense_gst',
            'report_profit',
            'report_stock',
            'report_stock_ledger',
            'report_sales_item',
            'report_return_items',
            'report_purchase_payments',
            'report_sales_payments',
            'report_gstr1',
            'report_gstr2',
            'report_sales_gst',
            'report_purchase_gst',
            'report_quotation_items',
            'report_purchase_order_item',
            'report_hsn_summary',
            'report_balance_sheet',
            'report_trial_balance',
            'report_ledger_statement',
            'report_ledger_entries',
            'report_reconciliation',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web'
            ]);
        }
        
        $this->command->info(count($permissions) . ' permissions have been created.');
    }
}