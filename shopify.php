<?php

/**
 * Plugin Name: Shopify Shortcode
 * Plugin URI: https://divi.tech
 * Description: Allows the usage of shopify emebed code into Divi Builder
 * Version: 1.0.1
 * Author: Eduard Ungureanu
 * Author URI: https://divi.tech
 */

/*
 * Usage [shopify domain="" apykey="" id="caf86812763" product_id=caf86812763]
 */

function display_shopify($atts, $content = null)
{
	$div_id = shortcode_atts(array(
		'domain' => '',
		'apikey' => '',
		'id' => '',
		'product_id' => ''
	), $atts);

	$domain = $div_id['domain'];
	$apikey = $div_id['apikey'];
	$full_div_id = 'product-component-' . $div_id['id'];
	$product_id = $div_id['product_id'];

	$output = '';

	$output .= '<div id="' . $full_div_id . '"></div>';
	$output .= '<script type="text/javascript">
	/*<![CDATA[*/
	(function () {
		var scriptURL = "https://sdks.shopifycdn.com/buy-button/latest/buy-button-storefront.min.js";
		if (window.ShopifyBuy) {
			if (window.ShopifyBuy.UI) {
				ShopifyBuyInit();
			} else {
				loadScript();
			}
		} else {
			loadScript();
		}
		function loadScript() {
			var script = document.createElement("script");
			script.async = true;
			script.src = scriptURL;
			(document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(script);
			script.onload = ShopifyBuyInit;
		}
		function ShopifyBuyInit() {
			var client = ShopifyBuy.buildClient({
				domain: "' . $domain . '",
				storefrontAccessToken: "' . $apikey . '",
			});
			ShopifyBuy.UI.onReady(client).then(function (ui) {
				ui.createComponent("product", {
					id: "' . $product_id . '",
					node: document.getElementById("' . $full_div_id . '"),
					moneyFormat: "%24%7B%7Bamount%7D%7D",
					options: {
						"product": {
							"styles": {
								"product": {
									"@media (min-width: 601px)": {
										"max-width": "calc(25% - 20px)",
										"margin-left": "20px",
										"margin-bottom": "50px"
									},
									"text-align": "left"
								},
								"button": {
									"font-weight": "bold",
									":hover": {
										"background-color": "#005077"
									},
									"background-color": "#005984",
									":focus": {
										"background-color": "#005077"
									}
								}
							},
							"contents": {
								"img": false,
								"title": false,
								"price": false
							},
							"text": {
								"button": "BUY"
							}
						},
						"productSet": {
							"styles": {
								"products": {
									"@media (min-width: 601px)": {
										"margin-left": "-20px"
									}
								}
							}
						},
						"modalProduct": {
							"contents": {
								"img": false,
								"imgWithCarousel": true,
								"button": false,
								"buttonWithQuantity": true
							},
							"styles": {
								"product": {
									"@media (min-width: 601px)": {
										"max-width": "100%",
										"margin-left": "0px",
										"margin-bottom": "0px"
									}
								},
								"button": {
									"font-weight": "bold",
									":hover": {
										"background-color": "#005077"
									},
									"background-color": "#005984",
									":focus": {
										"background-color": "#005077"
									}
								}
							},
							"text": {
								"button": "Add to cart"
							}
						},
						"cart": {
							"styles": {
								"button": {
									"font-weight": "bold",
									":hover": {
										"background-color": "#005077"
									},
									"background-color": "#005984",
									":focus": {
										"background-color": "#005077"
									}
								}
							},
							"text": {
								"total": "Subtotal",
								"button": "Checkout"
							}
						},
						"toggle": {
							"styles": {
								"toggle": {
									"font-weight": "bold",
									"background-color": "#005984",
									":hover": {
										"background-color": "#005077"
									},
									":focus": {
										"background-color": "#005077"
									}
								}
							}
						}
					},
				});
			});
		}
	})();
/*]]>*/
</script>';
	return $output;
}

add_shortcode('shopify', 'display_shopify');
