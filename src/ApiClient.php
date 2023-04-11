<?php

namespace RMS;

class ApiClient
{
    public function __construct() 
    {
        $this->paymentUrl = "https://pay.merchant.razer.com";
        $this->txntype =  "SALS";
    }

    /**
     * Get the name of the gateway.
     *
     * @return string
     */
    public function getName()
    {
        echo 'Razer Merchant Services';
    }

    /**
     * Set merchantId.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setMerchantId($value)
    {
        $this->merchantId =  $value;
    }

    /**
     * Set amount.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setAmount($value)
    {
        $this->amount =  $value;
    }

    /**
     * Set verifyKey.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setVerifyKey($value)
    {
        $this->verifykey =  $value;
    }

    /**
     * Set orderid.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setOrderId($value)
    {
        $this->orderid =  $value;
    }

    /**
     * Set billname.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillName($value)
    {
        $this->billname =  $value;
    }

    /**
     * Set billemail.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillEmail($value)
    {
        $this->billemail =  $value;
    }

    /**
     * Set billmobile.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillMobile($value)
    {
        $this->billmobile =  $value;
    }

    /**
     * Set paymentdesc.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setBillDesc($value)
    {
        $this->billdesc =  $value;
    }

    /**
     * Set returnurl.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setReturnUrl($value)
    {
        $this->returnurl =  $value;
    }

    /**
     * Set currency.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setCurrency($value)
    {
        $this->currency =  $value;
    }

    /**
     * Set channel.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setChannel($value)
    {
        $this->channel =  $value;
    }

    /**
     * Set callbackurl.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setCallbackUrl($value)
    {
        $this->callbackurl =  $value;
    }

    /**
     * Set notifyurl.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setNotifyUrl($value)
    {
        $this->notifyurl =  $value;
    }

    /**
     * Set txntype.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setTxnType($value)
    {
        $this->txntype =  $value;
    }

    /**
     * Set vcode.
     *
     * @return $this
     */
    public function configureVcode( $method = "MD5")
    {
        $signStr = $this->amount.$this->merchantId.$this->orderid.$this->verifykey;

        if( $method == "sha256" )
            $this->vcode =  hash('sha256', $signStr);
        else
            $this->vcode =  md5($signStr);
    }

    /**
     * Set paymentUrl.
     *
     * @return $this
     */
    public function setEnvironment($value)
    {
        if( $value == "SANDBOX")
            $this->paymentUrl = "https://sandbox.merchant.razer.com";
    }

    /**
     * create hosted payment form.
     *
     * @return $html
     */
    public function paymentViaHostedPage($value='PAY')
    {
        $html = "<form action='".$this->paymentUrl."/RMS/pay/".$this->merchantId."/' method='POST'>"
                . "<input type='hidden' name='merchant_id' value='".$this->merchantId."'>"
                . "<input type='hidden' name='amount' value='".$this->amount."'>"
                . "<input type='hidden' name='currency' value='".$this->currency."'>"
                . "<input type='hidden' name='channel' value='".$this->channel."'>"
                . "<input type='hidden' name='orderid' value='".$this->orderid."'>"
                . "<input type='hidden' name='bill_name' value='".$this->billname."'>"
                . "<input type='hidden' name='bill_email' value='".$this->billemail."'>"
                . "<input type='hidden' name='bill_mobile' value='".$this->billmobile."'>"
                . "<input type='hidden' name='bill_desc' value='".$this->billdesc."'>"
                . "<input type='hidden' name='vcode' value='".$this->vcode."'>"
                . "<input type='hidden' name='returnurl' value='".$this->returnurl."'>"
                . "<input type='hidden' name='callbackurl' value='".$this->callbackurl."'>"
                . "<input type='submit' value='".$value."'>";

        return $html;
    }

    /**
     * create direct server api call.
     *
     * @return $html
     */
    public function paymentViaDirectServer()
    {
        $params = array(
            'MerchantID'            => $this->merchantId,
            'ReferenceNo'           => $this->orderid,
            'TxnType'               => $this->txntype,
            'TxnChannel'            => $this->channel,
            'TxnCurrency'           => $this->currency,
            'TxnAmount'             => $this->amount,
            'CustName'              => $this->billname,
            'CustEmail'             => $this->billemail,
            'CustContact'           => $this->billmobile,
            'CustDesc'              => $this->billdesc,
            'Signature'             => $this->vcode,
            'ReturnURL'             => $this->returnurl,
            'CallbackURL'           => $this->callbackurl,
            'NotificationURL'       => $this->notifyurl
        );

        $params = http_build_query($params);
        $header[] = "Content-Type: application/x-www-form-urlencoded";

        $ch = curl_init( $this->paymentUrl."/RMS/API/Direct/1.4.0/index.php" );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt( $ch, CURLOPT_FRESH_CONNECT, 1);  // TRUE to force the use of a new connection instead of a cached one.
        curl_setopt( $ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );
        $result = curl_exec( $ch );
        curl_close( $ch );

        return $result;
    }
}
