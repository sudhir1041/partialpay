=== Disable payment method / COD fees / Advance COD or Partial payment for Order for WooCommerce ===
Contributors: rajeshsingh520
Tags: payment processing fees, cash on delivery, cod, smart cod, fee, cod fees 
Requires at least: 4.0.1
Tested up to: 6.8.1
Stable tag: 1.1.9.17
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Disable payment method for WooCommerce, Charge Payment processing FEES, Take Partial payment for Order, Advance COD or Partial payment for Order for WooCommerce

== Description ==

= Disable any payment gateway = 

This plugin allows you to disable any payment gateway of WooCommerce based on multiple conditions

&#9989; WooCommerce Disable payment method for specific product

&#9989; Disable payment method for shipping method in WooCommerce

&#9989; WooCommerce Disable payment method for specific category WooCommerce

&#9989; Payment gateways per products for WooCommerce

&#9989; Set WooCommerce payment gateway by country

&#9989; WooCommerce disable payment method for specific country

&#9989; Hide WooCommerce payment methods for specific shipping zones and min subtotal

&#9989; Disable payment methods based on WooCommerce cart total

&#9989; Disable payment method based on the postcode

&#9989; Disable payment method based on day of the Week

&#9989; Disable payment gateway for a specific city

&#9989; Disable payment gateway for a specific state

&#9989; Disable payment gateway for both city and state

&#9989; Disable Payment Method for a Coupon Code

&#9989; Hide Payment Methods Based on Shipping Class in the Cart

&#9989; Disable Payment Gateway for Specific User Role

&#9989; Disable Payment Gateways For Some Users

&#9989; Disable WooCommerce Payment methods based on cart item quantity

&#9989; Disable payment method if there is an back order product present in the user cart

&#9989; Restrict payment method by customer email

&#9989; Disable Woocommerce payment processing fee for specific country

&#9989; Restrict payment method by customer role

&#9989; Restrict WooCommerce credit card processing fee if the order total is less than a specific amount

&#9989; Restrict payment method by coupon code applied by customer

&#9989; Automatically remove coupons when partial payment is selected

&#9989; Partial payment option is disabled if any coupons are applied

&#9989; Disable COD when user select Different shipping address option during checkout

&#9989; In a multi currency site you can disable payment method based on the currency selected by the customer

&#9989; Disable PayPal payment method for the customer whose billing country is not USA

&#9989; Disable Stripe payment method for the customer whose billing state is not New York

&#9989; You can give reason to customer why certain payment method is not available for them, so they can understand why that payment method is not available for them

= Charge extra fees on use of any payment Gateway =

you can charge conditional extra fees on the use of a specific payment gateway, Here are few of the point you can achieve this through this plugin

&#9989; Charge extra fees for Cash on delivery order (COD)

&#9989; Charge extra fees for cash on delivery for specific country

&#9989; Charge extra fees for Cash on delivery for specific zones

&#9989; Charge extra fees for cash on delivery for specific post code

&#9989; Apply extra fees on use of some specific payment gateway from specific country

&#9989; Apply extra fees on COD order for some specific user roles or category

&#9989; Apply extra fees on COD order for some specific user only

&#9989; Charge a percentage based WooCommerce credit card processing fee

&#9989; Payment Gateway Based Fees 

&#9989; Product specific payment gateway fees

&#9989; Pay for Payment for WooCommerce

&#9989; In Multi Currency site you can apply extra fees and payment method selected by the customer

&#9989; WooCommerce credit card processing fee based on the order total

== Advance Fee for Cash on Delivery(COD) OR Partial payment for Order ==

This feature allows you to take small amount in advance and then take the remaining amount afterwards during the delivery (if customer want they can pay remaining amount before delivery as well). so using this you can avoid fake cash on delivery order.

E.g. Suppose the customer order total is $1000 and you have configured plugin to take min $10 as advance payment then customer can place that order by making a $10 payment and remaining payment he can do when the product is delivered to him. this way you can avoid fake cash on delivery orders.

You can restrict what payment option to be available when Partial payment for the order is selected.

you can exclude product from partial payment, there are two way to exclude, first way is by adding a condition so it wont give partial payment option when specific product is in the cart. Second way is to exclude the product such that partial payment option will be given but user will have to pay full amount for those excluded product in the cart and he can pay partial payment for other products.

You can collect Shipping charge as a partial payment amount, so if you have a shipping charge of $10 and customer is ordering product worth $1000 then he can pay $10 as partial payment and remaining amount of $1000 can be paid on delivery. So you can base the partial payment amount to be percentage of the Shipping charge or the subtotal of the order or a Fixed amount.

	
== PRO version features ==
	
&#9989; Create unlimited payment disable rule

&#9989; Create unlimited payment fees

&#9989; Create unlimited partial payment rules

&#9989; create conditional partial payment rules

&#9989; In multi currency website you can give partial payment option based on the currency selected by the customer

&#9989; Create conditional cod rule, so cod option will only be shown when the condition is met

[Buy pro version](https://www.piwebsolution.com/product/disable-payment-method-payment-fees-partial-payment-for-woocommerce/)

== Key features ==

* **Partial cod for WooCommerce** : Allow customers to pay a portion of the order amount and complete the order and pay remaining amount on delivery.
* **WooCommerce disable/remove payment method for shipping** : Disable or remove specific payment methods based on the selected shipping method.
* **Disable payment method WooCommerce** : Easily disable certain payment methods from the checkout page based on condition.
* **WooCommerce disable payment method for specific category** : Restrict payment methods based on the product categories in the cart.
* **WooCommerce disable payment method for specific country** : Limit payment methods based on the customer's country.
* **WooCommerce disable payment method for specific product** : Restrict certain payment methods for individual products.
* **WooCommerce disable payment methods based on cart conditions** : Customize available payment methods based on various conditions in the cart.
* **WooCommerce remove payment option from checkout** : Remove specific payment options from the checkout process.
* **Cash on delivery fee WooCommerce** : Add an extra fee for using the cash on delivery payment method.
* **WooCommerce add fee to payment method** : Apply additional fees to specific payment methods.
* **WooCommerce cash on delivery extra fee** : Charge an extra fee for cash on delivery orders.
* **WooCommerce payment processing fee** : Implement additional fees for different payment methods.
* **Charge percentage payment processing fee** : Charge a percentage based payment processing fee.
* **WooCommerce credit card processing fee**: Charge credit card processing fee based on the country, state, city, postcode, or shipping zone.

== Frequently Asked Questions ==

= How can I save money on Payment Gateway? =
This plugin allows you to select best payment gateway for different condition, so using this you can show the payment gateway that will charge you least processing fees based on the user location and its cart total.
E.g: Say you have 2 different payment gateways, Gateway A charges 1% processing fees for US and 2% for UK and Gateway B charges 2% for US and 1% for UK, now using our plugin you can set a rule so Customer from UK will only see Gateway B and customer from USA will get gateway A

= I want to offer PayPal gateway for order above $100 =
Yes you can do that using our Disable payment method plugin, You can set a condition to disable Paypal until customer cart subtotal is more then $100.

= I want to offer credit cart processing only when the order total is more then $1000 =
you can do that using our plugin, E.g: say you are using Stripe for card processing then you can set a rule do disable Stripe card processing for order below $1000

= WooCommerce credit card processing fee ? =
Yes, you can charge a credit card processing fee for orders that are processed through credit card payment gateways. This fee can be a fixed amount or a percentage of the order total.

= I want to disable Stripe for smaller order total =
you can set a rule to disable Stripe for orders whose subtotal is say less then $30

= I want to offer Cash on Delivery for the order less then $10 as I don't want gateway processing fees for small order =
You can disable COD for order below say $10 or amount set by you

= We wan't to offer Direct bank transfer for order above $1000 =
you can do that by disabling the Direct back transfer option for order below $1000

= Will It allow me to select the cheapest payment processing for each customer =
Yes, you can configure multiple rules so it enable the cheapest gateway for each customer. This way it will increase your profit

= I have a payment gateway that don't process order smaller then $5 =
Using this plugin you can disable those payment gateways that don't process order less then $5 when the customer order total is less then $5. This way user will always see the gateway that can process then payment

= Will this plugin work with all Payment gateways =
Yes this will work with all the payment gateways

= Can I disable payment gateway for specific city =
Yes using our Disable payment method plugin you can disable a Payment gateway for specific city or group of cities

= Can I disable payment gateway based on customer state =
Yes you can disable payment method based on user State, so you can disable PayPal option for customer ordering from New york.

= Can I disable payment gateway based on the postcode / zip code =
Yes you can disable a payment gateway based on a post code or range of post code

= I want to Disable Paypal for certain country where it is not available =
Yes you can disable PayPay or other payment gateway based on the customer country

= I want to enable Authorize payment gateway for Wholesale customer role =
Yes you can disable payment gateway based on the user or customer role

= I want to disable payment gateway for when customer orders a product belonging to specific category =
Yes you can do that using our Product category rule.

= I want to give option of the specific payment gateway when the user adds a specific coupon code =
Yes you can do this using our coupon code rule

= I want to give option of the payment gateway when specific shipping method is sued =
We have a shipping method rule you can use that to achieve this

= I want to disable a payment method based on the day =
Yes you can do this using our plugin

= I want to charge extra fees on Cash on delivery order =
Yes you can do this using our plugin

= I want to charge payment processing fees on COD for some country =
Yes you can do that you can control which country will be charged this extra fees on COD order

= My gateway charge extra fees for specific country =
You can use our woocommerce payment processing fees plugin to collect this extra fees from the customer from that country when they select that particular payment gateway.

= I want to take partial payment for the order =
Yes you can do that with this plugin, you can take a small fixed amount as partial payment amount and then you can take remaining amount on final product delivery.

= Can user make remaining amount payment before the order is delivered =
Yes, if customer wants he can do the remaining amount payment before the product is delivered

= What will be the order status of the Partially paid or COD deposit order =
The order status will be "Partially Paid"

= Can I create multiple Partial payment rule =
You can do that in the PRO version

= I want to offer different partial amount based on the location =
Yes you can do that in the PRO version, in that you can create multiple partial payment rules and apply them based on the customer Country, State, Postcode or shipping zone

= I want to disable cash on delivery when customer select different shipping address option then the billing address =
Yes you can do that with the rule "Different shipping address"

= I want to exclude some product from Partial payment =
Yes you can do that in the PRO version, there are 2 ways to exclude a product, in first method when excluded product will be in the cart partial payment option will not be given to the customer, in another method partial payment option will be given but customer will have to pay full amount for the excluded product.

= I only have single currency in my website what to select in currency field =
Leave the currency field blank if you have single currency in your website
 
= Is it HPOS compatible =
Yes the Free version and PRO version both are HPOS compatible

= Partial payment support WooCommerce checkout Block =
No, it doesn't support WooCommerce checkout Block, your checkout page should be the made using classic short code [woocommerce_checkout]

= I want to allow partial payment, but I want to charge shipping fees as partial payment amount =
Yes you can do that in the pro version, you can set the partial payment amount to be a percentage of the shipping fees.

= Can Change the text "Sorry, it seems that there are no available payment methods..." =
Yes you can change the text "Sorry, it seems that there are no available payment methods..." to any text you want from the Extra setting tab of the plugin setting.

= Disable payment method based on customer billing country =
Yes you can do that using our plugin, you can disable a payment method based on the customer billing country

= Disable payment method based on customer billing state =
Yes you can do that using our plugin, you can disable a payment method based on the customer billing state

= Disable payment method based on customer billing city =
Yes you can do that using our plugin, you can disable a payment method based on the customer billing city

= Disable payment method based on customer billing postcode =
Yes you can do that using our plugin, you can disable a payment method based on the customer billing postcode

= Disable payment method based on customer shipping country, state, city and postcode =
Yes you can do that using our plugin, you can disable a payment method based on the customer shipping country, state, city and postcode

= I want to charge payment processing fees based on the order total =
Yes you can charge Woocommerce payment processing fees based on the order total.



== Changelog ==

= 1.1.9.17 =
* Translation added for woocommerce payment processing fees module

= 1.1.9.16 =
* Tested for WC 9.8.5
* add custom hiding payment method message inside each rule

= 1.1.9.14 =
* New rule for billing country, state, city and postcode added
* Modify the message that is shown to the user when no payment method is available

= 1.1.9.13 =
* warning message when get payment method was called before wp_loaded so we adjusted the rules to not respond before wp_loaded event

= 1.1.9.11 =
* For woocommerce 9.8 we wont make custom request when payment method is changed in the block checkout page, as that is now part of woocommerce core

= 1.1.9.10 =
* Translation warning bug fixed

= 1.1.9.9 =
* code improvement 

= 1.1.9.7 =
* Tested for WC 9.7.2

= 1.1.9.6 =
* Tested for WC 9.7.0

= 1.1.9.4 =
* now percentage fee can be based on subtotal + shipping and discount coupon

= 1.1.9.3 =
* block based checkout not triggering payment method based fee fixed

= 1.1.9.2 =
* Charge partial payment fee upfront in pro version

= 1.1.9.1 =
* Tested for WC 9.6.0

= 1.1.9 =
* Cashfree payment gateway issue fixed

= 1.1.7.79 =
* UX improved

= 1.1.7.77 =
* Tested for WC 9.5.0

= 1.1.7.76 =
* confirmation dialog shown before deleting the rule

= 1.1.7.74 =
* code improvement
* unnecessary order state change removed

= 1.1.7.73 =
* reduced priority of woocommerce_available_payment_gateways filter in class-safety.php

= 1.1.7.72 =
* Tested for WP 6.7.1

= 1.1.7.71 =
* Increased the execution priority of gateway filter so it can remove any payment gateway (as Satispay was not been removed)

= 1.1.7.70 =
* Payment method fee (applied to cash on delivery payment method) was not removed when the payment method itself was been removed because of the selection of Partial payment option

= 1.1.7.69 =
* option to set default order status after partial payment done

= 1.1.7.67 =
* show tax information next to the total even when the Partial payment is selected

= 1.1.7.66 =
* Tested for WP 6.7.0

= 1.1.7.63 =
* Tested for WC 9.3.3

= 1.1.7.62 =
* Tested for WC 9.3.0

= 1.1.7.61 =
* Tested for WC 9.2.3

= 1.1.7.60 =
* Tested for WC 9.2.0

= 1.1.7.49 =
* Tested for WC 9.1.4

= 1.1.7.47 =
* small content change

= 1.1.7.46 =
* ccavanue bug fixed

= 1.1.7.44 =
* PHP 8.2 compatible
* Tested for WP 6.6.1

= 1.1.7.42 =
* Designing option given for the partial payment checkbox 
* Default design of the partial payment option changed

= 1.1.7.40 =
* change in the way we where detecting the initial payment method in the block checkout as earlier method had issue with Firefox with caching turned on

= 1.1.7.36 =
* Tested for WC 8.9.0

= 1.1.7.34 =
* Tested for WC 8.8.3

= 1.1.7.33 =
* Disable Place order button during payment method change in block checkout

= 1.1.7.32 =
* Tested for WP 6.5.2

= 1.1.7.31 =
* New rule of dates
* New rule of date range
* New rule of time range

= 1.1.7.27 =
* Order pay url was getting modified which is now fixed

= 1.1.7.26 =
* Phonepe Amount Mismatch bug fixed

= 1.1.7.24 =
* order-pay redirect removed 

= 1.1.7.23 =
* redirect loop fixed for order pay page

= 1.1.7.22 =
* order-pay-fees.js bug fixed for stripe

= 1.1.7.21 =
* Extra filter added for order pay page to give correct total
* Extra check on thank you page so if order is paid off in full we don't show extra rows below order total
* Order-pay url of the parent order will now redirect to the suborder if the parent order is paid off in partial
* for safety we have also added a redirect as well with same logic 

= 1.1.7.20 =
* Tested for WC 8.6.0

= 1.1.7.17 =
* Apply payment method fees in Block based checkout page

= 1.1.7.17 =
* Tested for WC 8.5.2

= 1.1.7.13 =
* Make fee table and you can select tax class for the fee tax 

= 1.1.7.12 =
* Tested for WC 8.3.0
* Tested for WP 6.4.2

= 1.1.7.11 =
* Phone pay payment solution related bug of "Amount Mismatch" fixed
* $state undefiend error in the rule fixed

= 1.1.7.10 =
* Tested for WC 8.2.2

= 1.1.7.9 =
* Tested for WP 6.4.0

= 1.1.7.6 =
* Tested for WC 8.2.0

= 1.1.7.4 =
* HPOS related bug fixed

= 1.1.7.3 =
* Tested for WP 6.3.1

= 1.1.7.2 =
* Some extra code added so online payment order completion email have sub order details

= 1.1.7.1 =
* New rule for product tag added

= 1.1.7 =
* bug fix of payment method not hiding

= 1.1.6 =
* Now even apply fee and disable payment method on order pay page
* Meta box working for HPOS

= 1.1.3 =
* Tested for WC 7.9.0

= 1.1.2 =
* Tested for WP 6.3.0
* Multi currency support added in

= 1.1.0 =
* Tested for WC 7.8.0

= 1.0.77 =
* cart hash modified to indicate change in partial payment selection

= 1.0.76 =
* Tested for WP 6.2.2

= 1.0.74 =
* Tested for WC 7.7.0

= 1.0.73 =
* Tested for WC 7.6.1

= 1.0.71 =
* Exclude product from partial payment added in the pro version

= 1.0.70 =
* Option to find the system name of the shipping method

= 1.0.69 =
* Tested for WC 7.5
* Tested for WP 6.2

= 1.0.67 =
* Reset main order total back to original total so report show correct revenue
* Tested for WC 7.4.1
* Disable parent email trigger on child order state change

= 1.0.66 =
* when cart total was less then the deposit amount (Bug fixed)
* Tested for WC 7.4.0

= 1.0.64 =
* conflict fixed

= 1.0.62 =
* Order total filter restricted as it was causing issue with some payment gateway

= v1.0.61 =
* Conflict with wallet fixed
* changed the partial payment order creation to handle the online payment gateways

= v1.0.60 =
* Now you can make 3 rules in free version as well
* Quick save option added 
* Bootstrap changed to avoid css conflicts
* We have skipped to version no 1.0.60 directly

= v1.0.49 =
* New rule to disable COD when user opt for different shipping address
