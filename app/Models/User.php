<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Country;
use Carbon\Carbon;
use App\Traits\UsesUuid;
use App\Models\Card;
use App\Models\BankingDetail;
use App\Models\Mcc;


class User extends Authenticatable
{
    use HasApiTokens, Notifiable, UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'youtube',
        'whatsapp',
        'verif_session_id',
        'kyc_verif_status',
        'mcc',
        'otp',
        'verification_code',
        'email',
        'password',
        'status',
        'business_name',
        'business_type',
        'address_line1',
        'address_line2',
        'dob',
        'postal_code',
        'post_town',
        'company_reg_number',
        'customerId',
        'industry_code',
        'verif_details_submitted',
        'country_code',
        'service_type',
        'turnover',
        'account_data',
    ];
    protected $guard = 'user';

    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected static function boot()  {
        parent::boot();
        static::creating(function ($post) {
            $post->{$post->getKeyName()} = (string) \Str::uuid();
        });
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function deposit()
    {
        return $this->hasMany('App\Model\Deposit', 'user_id');
    }

    public function coin()
    {
        return $this->belongsTo('App\Models\Countrysupported', 'pay_support');
    }

    public function cc()
    {
        return $this->belongsTo('App\Models\Countrysupported', 'pay_support');
    }

    public function xd()
    {
        return $this->belongsTo('App\Models\Country', 'country');
    }
    public function bla()
    {
        return $this->belongsTo(Country::class, 'country_address');
    }
    public function plan()
    {
        return $this->hasOne(SubscriptionPlan::class,'id','plan_id');
    }
    public function getCountry()
    {
        return Country::find($this->country);
    }
    public function getState()
    {
        return Shipstate::wherecountry_code($this->getCountry()->iso)->orderby('name', 'asc')->get();
    }
    public function getCountrySupported()
    {
        return Countrysupported::find($this->pay_support);
    }

    public function revenue()
    {
        return Transactions::whereReceiverId($this->id)->whereMode($this->live)->whereStatus(1)->limit(10)->orderby('id', 'desc')->get();
    }

    public function successTransactions()
    {
        return Transactions::whereReceiverId($this->id)->whereMode($this->live)->whereStatus(1)->where('type', '!=', 9)->sum('amount');
    }
    public function pendingTransactions()
    {
        return Transactions::whereReceiverId($this->id)->whereMode($this->live)->whereStatus(0)->where('type', '!=', 9)->sum('amount');
    }

    public function failedTransactions()
    {
        return Transactions::whereReceiverId($this->id)->whereMode($this->live)->whereStatus(2)->where('type', '!=', 9)->sum('amount');
    }
    public function getTransactions()
    {
        return Transactions::whereReceiverId($this->id)->wherearchive(0)->wheremode($this->live)->latest()->get();
    }
    public function firstTransactions()
    {
        return Transactions::whereReceiverId($this->id)->wherearchive(0)->wheremode($this->live)->limit(1)->orderby('created_at', 'desc')->first();
    }
    public function lastTransactions()
    {
        return Transactions::whereReceiverId($this->id)->wherearchive(0)->wheremode($this->live)->limit(1)->orderby('created_at', 'asc')->first();
    }
    public function archivedTransactions()
    {
        return Transactions::whereReceiverId($this->id)->wherearchive(1)->wheremode($this->live)->count();
    }
    public function getTickets()
    {
        return Ticket::whereUser_id($this->id)->latest()->paginate(4);
    }
    public function getWebsites()
    {
        return Merchant::whereUser_id($this->id)->wheremode($this->live)->latest()->get();
    }
    public function receivedMerchant()
    {
        return Exttransfer::whereStatus(1)->wheremode($this->live)->wherereceiver_id($this->id)->sum('total');
    }
    public function getInvoice()
    {
        return Invoice::whereUser_id($this->id)->wheremode($this->live)->orderby('created_at', 'desc')->get();
    }
    public function getInvoiceCustomer()
    {
        return Customer::whereUser_id($this->id)->wheremode($this->live)->orderby('created_at', 'desc')->get();
    }
    public function receivedInvoice()
    {
        return Invoice::whereStatus(1)->whereuser_id($this->id)->wheremode($this->live)->sum('real_total');
    }
    public function pendingInvoice()
    {
        return Invoice::whereStatus(0)->whereuser_id($this->id)->wheremode($this->live)->sum('real_total');
    }
    public function totalInvoice()
    {
        return Invoice::whereuser_id($this->id)->wheremode($this->live)->sum('real_total');
    }
    public function pendingMerchant()
    {
        return Exttransfer::whereStatus(0)->wheremode($this->live)->wherereceiver_id($this->id)->sum('total');
    }
    public function abandonedMerchant()
    {
        return Exttransfer::whereStatus(2)->wheremode($this->live)->wherereceiver_id($this->id)->sum('total');
    }
    public function totalMerchant()
    {
        return Exttransfer::wheremode($this->live)->wherereceiver_id($this->id)->sum('total');
    }
    public function storefront()
    {
        return Storefront::whereUser_id($this->id)->first();
    }
    public function storefrontCount()
    {
        return Storefront::whereUser_id($this->id)->get();
    }
    public function product()
    {
        return Product::whereUser_id($this->id)->orderby('id', 'desc')->get();
    }
    public function services($limit = null)
    {
        if($limit == null){
            return BookingServices::whereUser_id($this->id)->wherestatus(1)->orderby('id', 'desc')->get();
        }else{
            return BookingServices::whereUser_id($this->id)->wherestatus(1)->orderby('id', 'desc')->take($limit)->get();
        }
    }
    public function allServices($limit = null)
    {
        if($limit == null){
            return BookingServices::whereUser_id($this->id)->orderby('id', 'desc')->get();
        }else{
            return BookingServices::whereUser_id($this->id)->orderby('id', 'desc')->take($limit)->get();
        }
    }
    public function topProduct()
    {
        return Product::whereUser_id($this->id)->orderby('sold', 'desc')->limit(5)->get();
    }
    public function productCount()
    {
        return Product::whereUser_id($this->id)->wherecat_id(null)->count();
    }
    public function productCategory()
    {
        return Productcategory::whereUser_id($this->id)->wheremode($this->live)->get();
    }
    public function orders()
    {
        return Order::whereseller_id($this->id)->wherestatus(1)->wheremode($this->live)->orderby('id', 'desc')->get();
    }
    public function orderSum()
    {
        return Order::whereseller_id($this->id)->wherestatus(1)->wheremode($this->live)->latest()->sum('total');
    }
    public function orderForTheMonth()
    {
        return Order::whereseller_id($this->id)->wherestatus(1)->wheremode($this->live)->orderByRaw('DATE_FORMAT(created_at, "%m-%d")')->get();
    }
    public function orderForTheMonthSum()
    {
        return Order::whereseller_id($this->id)->wherestatus(1)->wheremode($this->live)->wheremonth('created_at', Carbon::now()->month)->sum('total');
    }
    public function shipping()
    {
        return Shipping::whereuser_id($this->id)->wheremode($this->live)->with('shippingState')->orderby('created_at', 'desc')->get();
    }
    public function coupon()
    {
        return Coupon::whereuser_id($this->id)->orderby('created_at', 'desc')->get();
    }
    public function storefrontCustomer($id)
    {
        return Storefrontcustomer::wherestore_id($id)->get();
    }

    public function bookingInfo(){
        return $this->belongsTo(BookingBusinessInfo::class,'id','uuid');
    }

    public function documents() {
        return $this->hasOne(ComplianceDocument::class, 'id');
    }

    public function account() {
        return $this->belongsTo(BankingDetail::class, 'id', 'user_id');
    }

    public function bankingbeneficiaries() {
        return $this->hasMany(BankingBeneficiary::class, 'user_id', 'id');
    }

    public function cards() {
        return $this->hasMany(Card::class, 'user_id',  'id');
    }

    public function virtualCard() {
        return Card::where('user_id',$this->id)->where('type', 'virtual')->first();
    }

    public function physicalCard() {
        return Card::whereUserId($this->id)->where('type', 'physical')->first();
    }
    public function pendingAppointmentCount() {
        return Bookings::whereUserId($this->id)->where('d_date', '>', Carbon::today())->count();
    }
    public function pendingAppointment() {
        return Bookings::whereUserId($this->id)->where('d_date', '>', Carbon::today())->paginate(10);
    }
    public function completedAppointmentCount() {
        return Bookings::whereUserId($this->id)->where('d_date', '<', Carbon::today())->count();
    }
    public function completedAppointment() {
        return Bookings::whereUserId($this->id)->where('d_date', '<', Carbon::today())->paginate(10);
    }
    public function bookingServices() {
        return BookingServices::whereUserId($this->id)->count();
    }
    public function bookingSum()
    {
        return Bookings::whereuser_id($this->id)->wherestatus(1)->latest()->sum('total');
    }
    public function bookingForTheMonth()
    {
        return Bookings::whereuser_id($this->id)->wherestatus(1)->orderByRaw('DATE_FORMAT(created_at, "%m-%d")')->get();
    }
    public function bookingForTheMonthSum()
    {
        return Bookings::whereuser_id($this->id)->wherestatus(1)->wheremonth('created_at', Carbon::now()->month)->sum('total');
    }

    public function euroAccount() {
        return BankingDetail::whereUserId($this->id)->whereCurrency('EUR')->first();
    }

    public function gBPAccount() {
        return BankingDetail::whereUserId($this->id)->whereCurrency('GBP')->first();
    }

    public function serviceType() {
        return Mcc::find($this->mcc);
    }

    public function website(){
        return $this->hasOne(Website::class,'user_id','id');
    }

    public function customDomain(){
        return $this->hasOne(Customdomain::class,'user_id','id');
    }

    public function mailDriver(){
        return $this->hasOne(CustomMailDriver::class,'user_id','id');
    }
}
