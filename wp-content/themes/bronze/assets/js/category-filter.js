/*!
 * Category filter
 *
 * Bronze 1.1.0
 */
/* jshint -W062 */
/* global BronzeParams,
BronzeMasonry,
BronzeInfiniteScroll,
BronzeLoadPosts,
BronzeYTVideoBg,
BronzeUi,
BronzeAjaxNav,
WPM,
alert,
console */
var BronzeCategoryFilter = function( $ ) {

	'use strict';

	return {

		init : function() {

			this.ajaxCategoryFilter();
			this.isotopeCategoryFilter();
		},

		/**
		 * AJAX filter
		 */
		ajaxCategoryFilter_bak : function () {
			var _this = this,
				selector = '#category-filter-post a',
				$content = $( 'main' ),
				$container,
				$trigger,
				$pagination,
				newPaginationMarkup,
				params,
				cat,
				href,
				data,
				$dom;

			$( document ).on( 'click', selector, function( event ) {

				if ( BronzeParams.isCustomizer ) {
					alert( BronzeParams.l10n.categoryFilterDisabledMsg );
					return false;
				}

				event.preventDefault();
				event.stopPropagation();

				$container = $( this ).parent().parent().parent().next( '.items' );
				$trigger = $container.next( '.trigger-container' );
				$pagination = $trigger.next( '.navigation' );
				params = $container.data( 'params' );
				cat = $( this ).data( 'cat-term' );
				href = $( this ).attr( 'href' );

				$container.animate( { 'opacity' : 0.44 } );
				$( selector ).removeClass( 'active' );
				$( this ).addClass( 'active' );

				data = {
					action : 'bronze_ajax_get_post_index_content',
					cat : $( this ).data( 'cat-term' ),
					params : params
				};
				$.post( BronzeParams.ajaxUrl, data, function( response ) {

					if ( response ) {

						$content.infinitescroll( 'binding', 'unbind' ); // destroy previous infinitescroll instance
						$content.data( 'infinitescroll', null );
						$( window ).unbind( '.infscr' );

						$dom = $( document.createElement( 'html' ) ); // Create HTML content
						$dom[0].innerHTML = response; // Set AJAX response as HTML dom
						if ( undefined !== $dom.find( '.paging-navigation').html() ) {
							newPaginationMarkup = $dom.find( '.paging-navigation').html();
						}

						$pagination.html( newPaginationMarkup );
						$trigger.html( $dom.find( '.trigger-container').html() );
						$container.html( $dom.find( '.items' ).html() ).animate( { 'opacity' : 1 } );
						_this.callBack();

						if ( ! BronzeParams.isCustomizer ) {
						}
					} else {
						$container.fadeIn();
					}
				} );

				return false;
			} );
		},

		/**
		 * Callback
		 */
		callBack : function() {

			var $content = $( '.items' );

			BronzeUi.resizeVideoBackground();
			BronzeUi.lazyLoad();
			BronzeUi.fluidVideos();
			BronzeUi.flexSlider();
			BronzeUi.lightbox();
			BronzeUi.addItemAnimationDelay();
			BronzeUi.parallax();
			BronzeLoadPosts.init();

			/* YT background */
			if ( 'undefined' !== typeof BronzeYTVideoBg ) {
				BronzeYTVideoBg.init();
			}

			if ( $( '.masonry-container' ).length ) {
				BronzeMasonry.init();

				if ( $content.data( 'isotope' ) ) {
					$content.isotope( 'reloadItems' ).isotope();
				}
			}

			BronzeInfiniteScroll.infiniteScrollTrigger();

			if ( $( '.infinitescroll-container' ).length ) {
				BronzeInfiniteScroll.infiniteScroll();
			}

			/* AJAX nav */
			if ( 'undefined' !== typeof BronzeAjaxNav ) {
				BronzeAjaxNav.setAjaxLinkClass();
			}

			/* Wolf Playilst */
			if ( 'undefined' !== typeof WPM ) {
				WPM.init();
			}

			if ( $content.find( '.twitter-tweet' ).length ) {
				$.getScript( 'http://platform.twitter.com/widgets.js' );
			}

			if ( $content.find( '.instagram-media' ).length ) {

				$.getScript( '//platform.instagram.com/en_US/embeds.js' );

				if ( 'undefined' !== typeof window.instgrm  ) {
					window.instgrm.Embeds.process();
				}
			}

			if ( $content.find( 'audio,video' ).length ) {
				$content.find( 'audio,video' ).mediaelementplayer();
			}
		},

		ajaxCategoryFilter : function () {
			if ( ! $( '.category-filter' ).length || $( 'body' ).hasClass( 'category' ) ) {
				return;
			}

			var _this = this,
				$container;

			$( '.ajax-filtered-content' ).each( function() {
				$container = $( this );
			} );

			$( '.category-filter-post a' ).on( 'click', function( event ) {
					event.preventDefault();

					if ( BronzeParams.isCustomizer ) {
						alert( BronzeParams.l10n.categoryFilterDisabledMsg );
						return;
					}

					var $link = $( this ),
						$container = $link.parent().parent().parent().next( '.items' ),
						params = $container.data( 'params' ),
						data,
						$dom,
						$newItems;

					data = {
						action : 'bronze_ajax_get_post_index_content',
						cat : $( this ).data( 'cat-term' ),
						params : params
					};
					$.post( BronzeParams.ajaxUrl, data, function( response ) {

						console.log( response );

						if ( response ) {
							$dom = $( document.createElement( 'html' ) ); // Create HTML content
							$dom[0].innerHTML = response; // Set AJAX response as HTML dom

							$newItems = $dom.find( '.items' ).html();

							$container.html( $newItems );
							_this.callBack();
							$( window ).trigger( 'resize' );
						}

					} );
			} );
		},

		/**
		 * Isotope filter
		 */
		isotopeCategoryFilter : function () {
			if ( ! $( '.category-filter' ).length || $( 'body' ).hasClass( 'tax-work_type' ) || $( 'body' ).hasClass( 'tax-video_type' ) || $( 'body' ).hasClass( 'tax-band' ) ) {
				return;
			}

			var $container,
				$filterContainer,
				layoutMode = 'masonry';

			$( '.filtered-content' ).each( function() {

				$container = $( this );

				if ( ! $container.hasClass( 'isotope-initialized' ) ) {
					$container.imagesLoaded( function() {
						$container.isotope( {
							itemSelector : '.entry',
							animationEngine: 'best-available'
						} );
					} ).addClass( 'isotope-initialized' );
				} else {
					console.log( 'Already loaded' );
				}
			} );

			$( '.category-filter a' ).on( 'click', function( event ) {

				event.preventDefault();

				if ( $( this ).hasClass( 'category-filter-post' ) ) {
					return;
				}

				var selector = $( this ).attr( 'data-filter' );
				$( this ).attr( 'href', '#' );

				$filterContainer = $( this ).parent().parent().parent();
				$container = $filterContainer.next( '.filtered-content' );

				if ( $container.hasClass( 'metro-container' ) ) {
					layoutMode = 'packery';
				}

				if ( $container.hasClass( 'isotope-initialized' ) ) {
					$container.imagesLoaded( function() {
						$container.isotope( {
							filter : '.' + selector,
							itemSelector : '.entry',
							layoutMode : layoutMode,
							animationEngine : 'best-available'
						} );
					} );
				}

				$filterContainer.find( 'a' ).removeClass( 'active' );
				$( this ).addClass( 'active' );
				
				setTimeout( function() {
					$( window ).trigger( 'resize' );
				}, 500 );
				
				return false;
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		BronzeCategoryFilter.init();
	} );

} )( jQuery );