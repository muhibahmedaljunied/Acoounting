import Try from './components/admin/try'
import Dashboard from './components/Dashboard'
import Company from './components/admin/setting/Company'
// import Category from './components/admin/category/Category'

import AccountsGuide from './components/admin/FinancialAccounting/accounting/AccountsGuide'
import AccountList from './components/admin/FinancialAccounting/accounting/AccountList'
import DailyRestrictions from './components/admin/FinancialAccounting/operation/DailyRestrictions'
import AccountBasicData from './components/admin/FinancialAccounting/AccountBasicData'


// ------------------------------------------------------------------staff---------------------------------------------------------------------------
import SalaryDetails from './components/admin/staff/SalaryDetails'

import AdministrativeStructure from './components/admin/staff/AdministrativeStructure'
import BasicData from './components/admin/staff/BasicData'
import Staff from './components/admin/staff/Staff'
import Sanction from './components/admin/staff/Sanction'

import Operation from './components/admin/staff/Operation'
import StaffReport from './components/admin/staff/StaffReport'
// ----------------------------------Category----------------------------------------------------------------------------------------------------------------------
import User from './components/admin/user/User'
import UpdateUser from './components/admin/user/UpdateUser'
import AddUser from './components/admin/user/AddUser'
// ----------------------------------------------Unit---------------------------------------------------------------
import Unit from './components/admin/unit/Unit'
import UpdateUnit from './components/admin/unit/UpdateUnit'
import AddUnit from './components/admin/unit/AddUnit'
// ----------------------------------User---------------------------------------------------------------------------------------------------
import Product from './components/admin/product/Product'

// ----------------------------------Store---------------------------------------------------------------------------------------------------
// ----------------------------------Shelve----------------------------------------------------------------------------------------------------------------------

import Store from './components/admin/store/Store'

// ----------------------------------Status---------------------------------------------------------------------------------------------------
import Status from './components/admin/status/Status'
import UpdateStatus from './components/admin/status/UpdateStatus'
import AddStatus from './components/admin/status/AddStatus'

// ------------------------------Style------------------------------
import RightSide from './components/admin/stock/Style/RightSide'
import FooterSide from './components/admin/stock/Style/FooterSide'
// -------------------------------Recive----------------------------
import Recive from './components/admin/stock/Recive/Recive'
// ------------------------------------------opening_inventory
import OpeningInventory from './components/admin/stock/OpeningInventory'
import Pricing from './components/admin/stock/Pricing'
// ----------------------------------transfer---------------------------------------------------------------------------------------------------
import Add from './components/admin/stock/transfer/Add'
import Transfer from './components/admin/stock/transfer/Transfer'
import TransferDetail from './components/admin/stock/transfer/TransferDetail'
// ----------------------------------Store---------------------------------------------------------------------------------------------------
// ----------------------------------Expence---------------------------------------------------------------------------------------------------
import TemporaleExpence from './components/admin/FinancialAccounting/expence/TemporaleExpence'
import Expence from './components/admin/FinancialAccounting/expence/Expence'
import ExpenceList from './components/admin/FinancialAccounting/expence/ExpenceList'
import ExpenceInvoice from './components/admin/FinancialAccounting/expence/ExpenceInvoice'
// ----------------------------------Income---------------------------------------------------------------------------------------------------
import TemporaleIncome from './components/admin/FinancialAccounting/income/TemporaleIncome'
import Income from './components/admin/FinancialAccounting/income/Income'
import IncomeList from './components/admin/FinancialAccounting/income/IncomeList'
import IncomeInvoice from './components/admin/FinancialAccounting/income/IncomeInvoice'
// ----------------------------------Supply---------------------------------------------------------------------------------------------------
import TemporaleSupply from './components/admin/stock/TemporaleSupply'
import Supply from './components/admin/stock/Supply'
import SupplyList from './components/admin/stock/SupplyList'
import SupplyInvoice from './components/admin/stock/SupplyInvoice'
import SupplyInvoiceUpdate from './components/admin/stock/SupplyInvoiceUpdate'
import SupplyRecive from './components/admin/stock/SupplyRecive'
import ReturnSupply from './components/admin/stock/returnsupply/ReturnSupply'
import ReturnSupplyList from './components/admin/stock/returnsupply/ReturnSupplyList'
import ReturnSupplyInvoice from './components/admin/stock/returnsupply/ReturnSupplyInvoice'
import ReturnSupplyRecive from './components/admin/stock/returnsupply/ReturnSupplyRecive'
// ----------------------------------cashing---------------------------------------------------------------------------------------------------
import TemporaleCash from './components/admin/stock/TemporaleCash'
import Cashing from './components/admin/stock/Cashing'
import Stock from './components/admin/stock/stock'
import CashList from './components/admin/stock/CashList'
import CashInvoice from './components/admin/stock/CashInvoice'
import CashInvoiceUpdate from './components/admin/stock/CashInvoiceUpdate'
import CashRecive from './components/admin/stock/CashRecive'
import ReturnCash from './components/admin/stock/returncash/ReturnCash'
import ReturnCashList from './components/admin/stock/returncash/ReturnCashList'
import ReturnCashInvoice from './components/admin/stock/returncash/ReturnCashInvoice'
import ReturnCashRecive from './components/admin/stock/returncash/ReturnCashRecive'
// ----------------------------------sale---------------------------------------------------------------------------------------------------
import SaleList from './components/admin/sale/SaleList'
import SaleInvoice from './components/admin/sale/SaleInvoice'
import SaleRecive from './components/admin/sale/SaleRecive'
import ReturnSale from './components/admin/sale/ReturnSale'
import ReceivableBond from './components/admin/sale/ReceivableBond'
import TemporaleSale from './components/admin/sale/TemporaleSale'
import New from './components/admin/sale/New'
import ReturnSaleList from './components/admin/sale/ReturnSaleList'
import ReturnSaleInvoice from './components/admin/sale/ReturnSaleInvoice'
// ---------------------------------Purchases---------------------------------------------------------------------------------------------------
import TemporalePurchase from './components/admin/purchase/TemporalePurchase'
import NewPurchase from './components/admin/purchase/NewPurchase'
import PurchaseList from './components/admin/purchase/PurchaseList'
import PurchaseInvoice from './components/admin/purchase/PurchaseInvoice'
import PurchaseRecive from './components/admin/purchase/PurchaseRecive'
import PaymentBond from './components/admin/purchase/PaymentBond'
import ReturnPurchase from './components/admin/purchase/ReturnPurchase'
import ReturnPurchaseList from './components/admin/purchase/ReturnPurchaseList'
import ReturnPurchaseInvoice from './components/admin/purchase/ReturnPurchaseInvoice'
// ----------------------------------Stock---------------------------------------------------------------------------------------------------
// ----------------------------------Purchases---------------------------------------------------------------------------------------------------
import Supplier from './components/admin/supplier/Supplier'
import UpdateSupplier from './components/admin/supplier/UpdateSupplier'
import AddSupplier from './components/admin/supplier/AddSupplier'
import SupplierAccountList from './components/admin/supplier/SupplierAccountList'
// ----------------------------------customer----------------------------------------------------------------------------------------------------------------------
import Customer from './components/admin/customer/Customer'
import UpdateCustomer from './components/admin/customer/UpdateCustomer'
import AddCustomer from './components/admin/customer/AddCustomer'
import CustomerAccountList from './components/admin/customer/CustomerAccountList'
// ----------------------------------Report---------------------------------------------------------------------------------------------------
import Movement from './components/admin/report/Movement'
import Sale from './components/admin/report/Sale'
import Purchase from './components/admin/report/Purchase'
import RepoCashing from './components/admin/report/RepoCashing'
import RepoCashingReturn from './components/admin/report/RepoCashingReturn'
import RepoStock from './components/admin/report/RepoStock'
import RepoSupply from './components/admin/report/RepoSupply'
import RepoSupplyReturn from './components/admin/report/RepoSupplyReturn'
// -------------------------------------------------------------------------------------------------------------------------------------------
const routes = [
  {
    path: '/try',
    component: Try
  },
  {
    path: '/',
    component: Dashboard
  },
  {
    path: '/company',
    component: Company
  },
  {
    // -------------------------------------------------------------------------------------------------------------------------------------------
    path: '/accounts_guide',
    component: AccountsGuide
  },
  {
    path: '/accounts_basic_data',
    component: AccountBasicData
  },
  {
    path: '/account_list',
    component: AccountList
  },
  {
    path: '/daily_restrictions',
    component: DailyRestrictions
  },
  {
    path: '/dashboard',
    component: Dashboard
  },
  {// ----------------------------------Staff---------------------------------------------------------------------------------------------------
    path: '/staff/basic_data',
    component: BasicData

  },
  {
    path: '/salary_details/:id',
    component: SalaryDetails

  },
  {
    path: '/tree_structure',
    component: AdministrativeStructure

  },

  {
    path: '/staff/staff',
    component: Staff

  },
  {
    path: '/staff/sanction',
    component: Sanction

  },
  {
    path: '/staff/operation',
    component: Operation

  },
  {
    path: '/staff/report',
    component: StaffReport

  },


  {
    path: '/store',
    component: Store
  },
  {
    path: '/recive',
    component: Recive
  },
  {
    path: '/opening_inventory',
    component: OpeningInventory
  },
  {
    path: '/pricing',
    component: Pricing
  },
  {
    path: '/transfer',
    component: Transfer
  },
  {
    path: '/create_transfer',
    component: Add
  },
  {
    path: '/transfer_details/:id',
    component: TransferDetail
  },
  // ----------------------------------transfer---------------------------------------------------------------------------------------------------


  {
    path: '/status',
    component: Status
  },
  {
    path: '/edit_status/:id',
    name: 'edit_status',
    component: UpdateStatus
  },
  {
    path: '/create_status',
    component: AddStatus
    // ----------------------------------status---------------------------------------------------------------------------------------------------
  },
  // ------------------------------------Unit-----------------------------------------------------
  {
    path: '/unit',
    name: 'unit',
    component: Unit
  },
  {
    path: '/edit_unit/:id',
    name: 'edit_unit',
    component: UpdateUnit
  },
  {
    path: '/create_unit',
    name: 'create_unit',
    component: AddUnit
  },
  // ------------------------------------------------------


  {
    path: '/user',
    name: 'user',
    component: User
  },
  {
    path: '/edit_user/:id',
    name: 'edit_user',
    component: UpdateUser
  },
  {
    path: '/create_user',
    name: 'create_user',
    component: AddUser
    // ----------------------------------Category---------------------------------------------------------------------------------------------------
  },
  {
    path: '/product',
    name: 'product',
    component: Product
  },
  {
    path: '/temporale_cash',
    component: TemporaleCash
  },

  {
    path: '/cash',
    component: Cashing
  },
  {
    path: '/cashlist',
    component: CashList
  },
  // { 
  //   path: '/cash_details/:id', 
  //   component:CashDetails
  // },
  {
    path: '/cash_invoice/:id',
    component: CashInvoice
  },
  {
    path: '/cash_recive/:id',
    component: CashRecive
  },
  {
    path: '/cash_invoice_update/:id',
    component: CashInvoiceUpdate
  },
  {
    path: '/returncash/:id',
    component: ReturnCash
  },
  {
    path: '/returncashlist/:id',
    component: ReturnCashList
  },
  {
    path: '/return_cash_invoice/:id',
    component: ReturnCashInvoice
  },
  {
    path: '/return_cash_recive/:id',
    component: ReturnCashRecive
  },   // ----------------------------------Category---------------------------------------------------------------------------------------------------
  {
    path: '/expence',
    component: Expence
  },
  {
    path: '/temporale_expence',
    component: TemporaleExpence
  },
  {
    path: '/expencelist',
    component: ExpenceList
  },
  {
    path: '/expence_invoice/:id',
    component: ExpenceInvoice
  },
  {
    path: '/income',
    component: Income
  },
  {
    path: '/temporale_income',
    component: TemporaleIncome
  },
  {
    path: '/incomelist',
    component: IncomeList
  },
  {
    path: '/income_invoice/:id',
    component: IncomeInvoice
  },



  // ==========================================
  {
    path: '/supply',
    component: Supply
  },
  {
    path: '/temporale_supply',
    component: TemporaleSupply
  },
  {
    path: '/supplylist',
    component: SupplyList
  },
  {
    path: '/supply_invoice/:id',
    component: SupplyInvoice
  },
  {
    path: '/supply_recive/:id',
    component: SupplyRecive
  },
  {
    path: '/supply_invoice_update/:id',
    component: SupplyInvoiceUpdate
  },
  {
    path: '/returnsupply/:id',
    component: ReturnSupply
  },
  {
    path: '/returnsupplylist/:id',
    component: ReturnSupplyList
  },
  {
    path: '/return_supply_invoice/:id',
    component: ReturnSupplyInvoice
  },
  {
    path: '/return_supply_recive/:id',
    component: ReturnSupplyRecive
  },
  {// ----------------------------------sale-----------------------------------------------------------------------------
    path: '/listsale',
    component: SaleList
  },
  {
    path: '/sale_invoice/:id',
    component: SaleInvoice
  },
  {
    path: '/sale_recive',
    component: SaleRecive
  },
  {
    path: '/ReceivableBond/:id',
    component: ReceivableBond
  },
  {
    path: '/ReceivableBond',
    component: ReceivableBond
  },
  {
    path: '/return_sale/:id',
    component: ReturnSale
  },
  {
    path: '/returnsalelist/:id',
    component: ReturnSaleList
  },
  {
    path: '/return_sale_invoice/:id',
    component: ReturnSaleInvoice
  },
  {
    path: '/temporale_sale',
    component: TemporaleSale
  },
  {
    path: '/newsale',
    component: New
  },
  {
    path: '/temporale_Purchase',
    component: TemporalePurchase
  },
  {
    path: '/newpurchase',
    component: NewPurchase
  },
  {
    path: '/listpurchase',
    component: PurchaseList
  },
  {
    path: '/purchase_invoice/:id',
    component: PurchaseInvoice
  },
  {
    path: '/purchase_recive',
    component: PurchaseRecive
  },
  {
    path: '/PaymentBond/:id',
    component: PaymentBond
  },
  {
    path: '/PaymentBond',
    component: PaymentBond
  },
  {
    path: '/return_purchase/:id',
    component: ReturnPurchase
  },
  {
    path: '/returnpurchaselist/:id',
    component: ReturnPurchaseList
  },
  {
    path: '/return_purchase_invoice/:id',
    component: ReturnPurchaseInvoice
  },
  {
    path: '/stock',
    component: Stock
  },

  {
    path: '/supplier',
    component: Supplier
  },
  {
    path: '/edit_supplier/:id',
    name: 'edit_supplier',
    component: UpdateSupplier
  },
  {
    path: '/create_supplier',
    component: AddSupplier
  },
  {
    path: '/supplier_account_list',
    component: SupplierAccountList
  },
  {
    path: '/customer',
    name: 'customer',
    component: Customer
  },
  {
    path: '/customer_account_list',
    component: CustomerAccountList
  },
  {
    path: '/edit_customer/:id',
    name: 'edit_customer',
    component: UpdateCustomer
  },
  {
    path: '/create_customer',
    name: 'create_customer',
    component: AddCustomer
    // ----------------------------------customer---------------------------------------------------------------------------------------------------
  },
  {
    path: '/movements',
    component: Movement
  },
  {
    path: '/sales',
    component: Sale
  },
  {
    path: '/purchases',
    component: Purchase
  },
  {
    path: '/reportcashing',
    component: RepoCashing
  },
  {
    path: '/reportcashingreturn',
    component: RepoCashingReturn
  },
  {
    path: '/reportstock',
    component: RepoStock
  },
  {
    path: '/reportsupply',
    component: RepoSupply
    // --------------------------------------Report----------------------------------------------------------------------------------------------

  },
  {
    path: '/reportsupplyreturn',
    component: RepoSupplyReturn
    // --------------------------------------Report----------------------------------------------------------------------------------------------

  },



]

export default routes;





