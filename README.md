# Magento1_Senddiscount
This is a module for Magento 1.x CMS.<br />
Module for subscribing registered and unregistered customers to price change email. <br />
You can enable your registered and unregistered customers to subscribe to price change email.<br />
- When the module "Subscribe to the product discount" is enabled, a "I want to be informed if product will be discounted" link appears on every product page. <br />
- Customers can click the link to subscribe to emails related to the product.<br />
- Whenever the price changes, or the product goes on special, everyone who has signed up to be notified receives an email about it.<br />
- Eshop owner has in the table databse of customers, who are waiting for discount for particular product.<br />
- The emails will be sended for customers automatically by Cron (default one time for day at 00:00) to all subsribed users and products which price has changed.<br />
- When user get an email about price change of product, he can unsubscribe from email messages by clicking on link in the email (only for one product or all products subscription).<br />
<br />
- When customer click on link "I want to be informed if product will be discounted", new form is loaded by javascript (the form is displayed on the same place without reloading a page).<br />
<br />
Form has these input boxes:<br />
- First name - input box - required<br />
- Surname - input box - required<br />
- Email - input box - required<br />
- Phone - input box - optional<br />
- Submit button "Send an emial, when product is discounted"<br />
<br />
When customer send form, new messaage will be displayed, messaage must be managed in static html block in admin. The default text is "We are going to send you an email or give a call when this product will be discounted". <br />
- Send form will be done by AJAX (without reloading of page).<br />
<br />
- The data that entered customers into the input fields in the form will be validated on the client and sever sides of the store.<br />
<br />
Admin of Magento will have new view, under section "SALES", called "Potential Customer", table of standart layout with the ability filtering and sorting data. <br />
The table has columns:<br />
- Date + Time<br />
- IP address of customer<br />
- First name<br />
- Surname<br />
- Email<br />
- Phone<br />
- SKU of product<br />
- ID of product<br />
- Status of subscription: pending, notified or cancelled<br />
<br />
Admin user can manually change status or delete customer data from list<br />
<br />
SKU, in the table, is link to product detail page<br />
<br />
Admin can export the list of customers into CSV-, Excel-, XML-files.<br />
<br />
Admin can manage some users for one time (change status or delete) through the "mass-actions". <br />
<br />
Installation of the extension needs to be done through Magento Connect in the administrative part of the site.<br />
<br />
When you install this extension in the administrative part of the Magento will be created a new static CMS block - "For the message of module "Send Discount" " . In this block you can change the success message, which will be shown in the form on product page, when customer have subscribed to price change of the product. The default message is "We are going to send you an email or give a call when this product will be discounted".<br />
<br />
To set up product alerts:<br />
1. On the Admin menu, select System > Configuration. Then in the panel on the left, under<br />
Catalog, select Catalog.<br />
2. Click to expand the Product Alerts section, and do the following:<br />
- To offer price change alerts to your customers, set Allow Alert When Product Price<br />
Changes to "Yes".<br />
- Set Price Alert Email Template to the template that you want to use for the price alert<br />
notifications.<br />
