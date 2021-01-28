/*!
 * Additional Theme Methods
 *
 * Bronze 1.1.0
 */
/* jshint -W062 */

/* global BronzeParams, BronzeUi, WVC, Cookies, Event, WVCParams, CountUp */
var Bronze = (function ($) {
	'use strict';

	return {
		initFlag: false,
		isEdge: navigator.userAgent.match(/(Edge)/i) ? true : false,
		isWVC: 'undefined' !== typeof WVC,
		isMobile: navigator.userAgent.match(
			/(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i
		)
			? true
			: false,
		loaded: false,
		hasScrolled: false,
		menuSkin: 'light',
		preloaded: false,
		inIframe  : window.location !== window.top.location,
		sessionStorageAllowed : window.sessionStorage,

		/**
		 * Init all functions
		 */
		init: function () {
			if (this.initFlag) {
				return;
			}

			if (this.initFlag) {
				return;
			}

			var _this = this;

			this.isMobile = BronzeParams.isMobile;

			this.liveSearch();
			this.transitionCosmetic();
			this.quickView();
			this.loginPopup();
			this.stickyProductDetails();
			this.tooltipsy();
			this.WCQuantity();
			this.singlePostNav();
			this.metroClasses();
			this.toggleMenu();
			this.cursorFollowingTitle();

			if (this.isWVC) {
				WVC.fireAnimation = false;

				WVC.delayWow('#menu-o-left');
				WVC.resetAOS('#menu-o-left');

				WVC.delayWow('#menu-o-left');
				WVC.resetAOS('#menu-o-left');

				//WVC.delayWow();
				//WVC.resetAOS();

				$(window).on('wvc_fullpage_changed', function (event) {
					WVC.resetAOS('#menu-o-left');
					WVC.resetAOS('#menu-o-right');
				});
			}

			$(window).on('wwcq_product_quickview_loaded', function (event) {});

			$(window).scroll(function () {
				var scrollTop = $(window).scrollTop();
				_this.stickyMenuSkin(scrollTop);
				_this.backToTopSkin(scrollTop);
			});

			// Resize event
			$(window)
				.resize(function () {
					_this.metroClasses();
				})
				.resize();

			this.initFlag = true;
		},

		toggleMenu: function () {
			var _this = this,
				$body = $('body');

			$(document).on('click', '.toggle-custom-overlay-menu', function (
				event
			) {
				event.preventDefault();

				//$( window ).trigger( 'bronze_side_panel_toggle_button_click', [ $( this ) ] );

				if ($body.hasClass('custom-overlay-menu-toggle')) {
					$body.removeClass('custom-overlay-menu-toggle');

					if (_this.isWVC) {
						$('#menu-o-left').one(
							BronzeUi.transitionEventEnd(),
							function () {
								//console.log( 'delay wow' );
								setTimeout(function () {
									WVC.delayWow('#menu-o-left');
									WVC.resetAOS('#menu-o-left');

									WVC.delayWow('#menu-o-right');
									WVC.resetAOS('#menu-o-right');
								}, 200);
							}
						);
					}
				} else {
					$body.removeClass('loginform-popup-toggle');
					$body.removeClass('overlay-menu-toggle');

					$body.addClass('custom-overlay-menu-toggle');

					if (_this.isWVC) {
						WVC.delayWow('#menu-o-left');
						WVC.resetAOS('#menu-o-left');

						WVC.delayWow('#menu-o-right');
						WVC.resetAOS('#menu-o-right');

						$('#menu-o-left').one(
							BronzeUi.transitionEventEnd(),
							function () {
								//console.log( 'do wow' );
								WVC.doWow();
								WVC.doAOS('#menu-o-left');
								WVC.doAOS('#menu-o-right');
								window.dispatchEvent(new Event('scroll')); // Force WOW effect
							}
						);
					}
				}
			});
		},

		liveSearch: function () {
			var $formContainer = $('.cta-container > .search-container'),
				$form = $formContainer.find('form'),
				searchInput = $formContainer.find('input[type="search"]'),
				$loader = $formContainer.find('.search-form-loader'),
				timer = null,
				$resultContainer,
				action = 'bronze_ajax_live_search',
				result;

			if ($form.hasClass('woocommerce-product-search')) {
				action = 'bronze_ajax_woocommerce_live_search';
			}

			if (!$formContainer.find('.live-search-results').length) {
				$(
					'<div class="live-search-results"><ul></u></div>'
				).insertAfter(searchInput);
			}

			($resultContainer = $formContainer.find('.live-search-results')),
				(result = $resultContainer.find('ul'));

			searchInput.on('keyup', function (event) {
				// clear the previous timer
				clearTimeout(timer);

				var $this = $(this),
					term = $this.val();

				if (8 === event.keyCode || 46 === event.keyCode) {
					$resultContainer.fadeOut();
					$loader.fadeOut();
				} else if ('' !== term) {
					// 200ms delay so we dont exectute excessively
					timer = setTimeout(function () {
						$loader.fadeIn();

						var data = {
							action: action,
							s: term,
						};

						$.post(BronzeParams.ajaxUrl, data, function (
							response
						) {
							if ('' !== response) {
								result.empty().html(response);
								$resultContainer.fadeIn();
								$loader.fadeOut();
							} else {
								$resultContainer.fadeOut();
								$loader.fadeOut();
							}
						});
					}, 200); // timer
				} else {
					$resultContainer.fadeOut();
					$loader.fadeOut();
				}
			});
		},

		/**
		 * Tooltip
		 */
		tooltipsy: function () {
			if (!this.isMobile) {
				var $tipspan,
					selectors =
						'.wolf_add_to_wishlist:not(.no-tipsy), .quickview-product-add-to-cart-icon';

				$(selectors).tooltipsy();

				$(document).on('added_to_cart', function (
					event,
					fragments,
					cart_hash,
					$button
				) {
					if (
						$button.hasClass('wvc-ati-add-to-cart-button') ||
						$button.hasClass('wpm-add-to-cart-button') ||
						$button.hasClass('wolf-release-add-to-cart') ||
						$button.hasClass('product-add-to-cart')
					) {
						$tipspan = $button.find('span');

						$tipspan.data('tooltipsy').hide();
						$tipspan.data('tooltipsy').destroy();

						$tipspan.attr(
							'title',
							BronzeParams.l10n.addedToCart
						);

						$tipspan.tooltipsy();
						$tipspan.data('tooltipsy').show();

						setTimeout(function () {
							$tipspan.data('tooltipsy').hide();
							$tipspan.data('tooltipsy').destroy();
							$tipspan.attr(
								'title',
								BronzeParams.l10n.addToCart
							);
							$tipspan.tooltipsy();

							$button.removeClass('added');
						}, 4000);
					} else if ($button.hasClass('wvc-button')) {
						$button.text(BronzeParams.l10n.addedToCart);

						setTimeout(function () {
							$button.text(BronzeParams.l10n.addToCart);
							$button.removeClass('added');
						}, 4000);
					}
				});
			}
		},

		loginPopup: function () {
			var $body = $('body');

			$(document).on(
				'click',
				'.account-item-icon-user-not-logged-in, .close-loginform-button',
				function (event) {
					event.preventDefault();

					if ($body.hasClass('loginform-popup-toggle')) {
						$body.removeClass('loginform-popup-toggle');
					} else {
						$body.removeClass('overlay-menu-toggle');

						if ($('.wvc-login-form').length) {
							$body.addClass('loginform-popup-toggle');
						} else {
							/* AJAX call */
							$.post(
								BronzeParams.ajaxUrl,
								{ action: 'bronze_ajax_get_wc_login_form' },
								function (response) {
									console.log(response);

									if (response) {
										$('#loginform-overlay-content').append(
											response
										);

										$body.addClass(
											'loginform-popup-toggle'
										);
									}
								}
							);
						}
					}
				}
			);

			if (!this.isMobile) {
				$(document).mouseup(function (event) {
					if (1 !== event.which) {
						return;
					}

					var $container = $('#loginform-overlay-content');

					if (
						!$container.is(event.target) &&
						$container.has(event.target).length === 0
					) {
						$body.removeClass('loginform-popup-toggle');
					}
				});
			}
		},

		/**
		 * Sticky menu skin
		 */
		stickyMenuSkin: function (scrollTop) {
			var $body = $('body');

			if (scrollTop < 550 || this.isMobile) {
				$body.removeClass('menu-skin-ts-dark menu-skin-ts-light');
				return;
			}

			if (
				$body.hasClass('sticky-menu-transparent') &&
				$body.hasClass('sticking') &&
				!$body.hasClass('wvc-scrolling') &&
				!$body.hasClass('scrolling')
			) {
				if ($('.wvc-row-visible').first().hasClass('wvc-font-dark')) {
					$body.addClass('menu-skin-ts-light');
					$body.removeClass('menu-skin-ts-dark');
				} else {
					$body.addClass('menu-skin-ts-dark');
					$body.removeClass('menu-skin-ts-light');
				}
			}
		},

		/**
		 * Check back to top color
		 */
		backToTopSkin: function (scrollTop) {
			var $button = $('#back-to-top'),
				$body = $('body');

			if (
				!$button.length ||
				$('body').hasClass('wvc-scrolling') ||
				$('body').hasClass('scrolling')
			) {
				return;
			}

			if (scrollTop < 550 || this.isMobile) {
				$button.removeClass('back-to-top-light');
				return;
			}

			if (scrollTop + $(window).height() >= $(document).height() - 30) {
				if (
					$('.content-inner')
						.next('.wvc-row')
						.hasClass('wvc-font-dark')
				) {
					$button.removeClass('back-to-top-light');
					//console.log( 'bottom?' );
				}
			} else {
				if ($('.wvc-row-visible').last().hasClass('wvc-font-light')) {
					$button.addClass('back-to-top-light');
				} else if (
					$('.site-footer').length &&
					$('.site-footer').hasClass('wvc-font-light') &&
					scrollTop + $(window).height() >
						$('.site-footer').offset().top
				) {
					$button.addClass('back-to-top-light');
				} else {
					$button.removeClass('back-to-top-light');
				}
			}
		},

		/**
		 * Product quickview
		 */
		quickView: function () {
			$(document).on('added_to_cart', function (
				event,
				fragments,
				cart_hash,
				$button
			) {
				if ($button.hasClass('quickview-product-add-to-cart')) {
					//console.log( 'good?' );
					$button.attr('href', BronzeParams.WooCommerceCartUrl);
					$button
						.find('span')
						.attr('title', BronzeParams.l10n.viewCart);
					$button.removeClass('ajax_add_to_cart');
				}
			});
		},

		stickyProductDetails: function () {
			if ($.isFunction($.fn.stick_in_parent)) {
				if ($('body').hasClass('sticky-product-details')) {
					$('.entry-single-product .summary').stick_in_parent({
						offset_top:
							parseInt(
								BronzeParams.portfolioSidebarOffsetTop,
								10
							) + 40,
					});
				}
			}
		},

		/**
		 * https://stackoverflow.com/questions/48953897/create-a-custom-quantity-field-in-woocommerce
		 */
		WCQuantity: function () {
			$(document).on('click', '.wt-quantity-minus', function (event) {
				event.preventDefault();
				var $input = $(this).parent().find('input.qty'),
					val = parseInt($input.val(), 10),
					step = $input.attr('step');
				step = 'undefined' !== typeof step ? parseInt(step) : 1;

				if (val > 1) {
					$input.val(val - step).change();
				}
			});

			$(document).on('click', '.wt-quantity-plus', function (event) {
				event.preventDefault();

				var $input = $(this).parent().find('input.qty'),
					val = parseInt($input.val(), 10),
					step = $input.attr('step');
				step = 'undefined' !== typeof step ? parseInt(step) : 1;
				$input.val(val + step).change();
			});
		},

		metroClasses: function () {
			if ($('.product-display-metro').length) {
				$('.product-display-metro')
					.find('.entry')
					.each(function () {
						if (250 > $(this).width() || $(this).hasClass('sale')) {
							$(this).addClass('m-small');
						} else {
							$(this).removeClass('m-small');
						}
					});
			}
		},

		singlePostNav: function () {
			$('.post-nav-link-overlay').on('mouseover', function () {
				$(this).parent().toggleClass('nav-hover');
			});
		},

		/**
		 * Overlay transition
		 */
		transitionCosmetic: function () {
			var _this = this;

			$(document).on('click', '.internal-link:not(.disabled)', function (
				event
			) {
				if (!event.ctrlKey) {
					event.preventDefault();

					var $link = $(this);

					$('body').removeClass(
						'mobile-menu-toggle overlay-menu-toggle offcanvas-menu-toggle loginform-popup-toggle lateral-menu-toggle'
					);
					$('body').addClass('loading transitioning');

					if ($('#loading-overay').length) {
						$('.loader-bg-top').one(
							BronzeUi.transitionEventEnd(),
							function () {
								if (
									$('#loader-image').length &&
									!sessionStorage.getItem('session_loaded')
								) {
									//if ( 1 === 1 ) {
									$('body').addClass('logo-fadein');

									$('#loader-image').one(
										BronzeUi.transitionEventEnd(),
										function () {
											$('.imgloading-container').css({
												width: '100%',
											});

											setInterval(function () {
												//console.log( $( '.imgloading-container' ).width() );
												//sessionStorage.setItem( 'loading-logo-width', $( '.imgloading-container' ).width() );
											}, 10);

											//Cookies.remove( BronzeParams.themeSlug + '_session_loaded' );
											window.location = $link.attr(
												'href'
											);
										}
									);
								} else if (
									$('#loader-image').length &&
									sessionStorage.getItem('session_loaded')
								) {
									// lighter animation?
									window.location = $link.attr('href');
								} else {
									//Cookies.remove( BronzeParams.themeSlug + '_session_loaded' );
									window.location = $link.attr('href');
								}
							}
						);
					} else {
						window.location = $link.attr('href');
					}
				}
			});
		},

		/**
		 * Page preLoad
		 */
		preloadAnimation: function () {
			var loadingLogoWidth = sessionStorage.getItem('loading-logo-width');

			if (0 !== loadingLogoWidth) {
				console.log(loadingLogoWidth);

				$('.imgloading-container').css({
					animation: 'none',
					width: loadingLogoWidth,
				});
			} else {
			}
		},

		/**
		 * Title following cursor effect
		 */
		cursorFollowingTitle: function () {
			if (this.isMobile) {
				return;
			}

			$('.hover-effect-cursor .entry').each(function () {
				var $item = $(this),
					$title = $item.find('.entry-summary');

				$title
					.addClass('entry-summary-cursor')
					.detach()
					.prependTo('body');

				$title.find('a').contents().unwrap(); // strip tags

				$item.on('mousemove', function (e) {
					$title.css({
						top: e.clientY,
						left: e.clientX,
					});
				});

				$item
					.on('mouseenter', function () {
						$title.addClass('tip-is-active');
					})
					.on('mouseleave', function () {
						$title.removeClass('tip-is-active');
					});

				$(window).scroll(function () {
					if (
						$title.hasClass('tip-is-active') &&
						($title.offset().top < $item.offset().top ||
							$title.offset().top >
								$item.offset().top + $item.outerHeight())
					) {
						$title.removeClass('tip-is-active');
					}
				});
			});
		},

		/**
		 * Page Load
		 */
		loadingAnimation: function () {
			var _this = this,
				loadingLogoWidth;

			$('body').addClass('loaded');

			if (
				$('#loader-image').length &&
				this.sessionStorageAllowed &&
				!sessionStorage.getItem('session_loaded')
				&& ! this.inIframe
			) {
				$('#loader').css({
					visibility: 'visible',
				});

				$('.imgloading-container-aux').one(
					BronzeUi.transitionEventEnd(),
					function () {
						$('body').addClass('reveal');

						$('.loader-bg-top').one(
							BronzeUi.transitionEventEnd(),
							function () {
								_this.fireContent();

								setTimeout(function () {
									$('body').addClass('one-sec-loaded');
									BronzeUi.videoThumbnailPlayOnHover();
									$('.imgloading-container').removeAttr(
										'style'
									);
									sessionStorage.setItem(
										'session_loaded',
										true
									);
								}, 100);
							}
						);
					}
				);
			} else if ($('#loading-overay').length) {
				$('body').addClass('reveal');

				$('.loader-bg-top').one(
					BronzeUi.transitionEventEnd(),
					function () {
						_this.fireContent();

						setTimeout(function () {
							$('body').addClass('one-sec-loaded');
							BronzeUi.videoThumbnailPlayOnHover();
						}, 100);
					}
				);
			} else {
				$('body').addClass('reveal');
				_this.fireContent();

				setTimeout(function () {
					$('body').addClass('one-sec-loaded');
					BronzeUi.videoThumbnailPlayOnHover();
				}, 100);
			}
		},

		fireContent: function () {
			var _this = this;

			// Animate
			$(window).trigger('page_loaded');
			BronzeUi.wowAnimate();

			if (this.isWVC) {
				//alert( 'fire' );
				WVC.wowAnimate();
				WVC.AOS();
			}

			$(window).trigger('resize');
			window.dispatchEvent(new Event('resize'));
			window.dispatchEvent(new Event('scroll')); // Force WOW effect
			$(window).trigger('just_loaded');
		},
	};
})(jQuery);

(function ($) {
	'use strict';

	$(document).ready(function () {
		//Bronze.preloadAnimation();
		Bronze.init();
	});

	$(window).load(function () {
		Bronze.loadingAnimation();
	});
})(jQuery);
