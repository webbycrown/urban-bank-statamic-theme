jQuery(document).ready(function () {
function bwMakeSwiper(sel, opts) {
  var node = document.querySelector(sel);
  if (!node) {
    return null;
  }
  opts = opts || {};
  var slides = node.querySelectorAll(".swiper-slide").length;
  if (!slides) {
    return null;
  }
  if (opts.loop) {
    var view = typeof opts.slidesPerView === "number" ? opts.slidesPerView : 1;
    if (opts.breakpoints) {
      Object.keys(opts.breakpoints).forEach(function (key) {
        var per = opts.breakpoints[key].slidesPerView;
        if (typeof per === "number" && per > view) {
          view = per;
        }
      });
    }
    if (slides < view * 2) {
      opts.loop = false;
    }
  }
  try {
    return new Swiper(sel, opts);
  } catch (err) {
    return null;
  }
}

function bwEqualizeBlogBoxes() {
  var groups = document.querySelectorAll(
    ".bw_blog_page_wrap:not(.bw_pricing_page_wrap), .bw_blog_section .swiper-wrapper, .bw_career_option_group"
  );
  groups.forEach(function (group) {
    var cards = [];
    for (var i = 0; i < group.children.length; i++) {
      var child = group.children[i];
      if (child.classList.contains("bw_blog_card_box") || child.classList.contains("bw_career_option_item")) {
        if (child.classList.contains("is-load-more-hidden")) {
          continue;
        }
        cards.push(child);
      } else if (child.classList.contains("swiper-slide")) {
        var box = child.querySelector(".bw_blog_card_box");
        if (box) {
          cards.push(box);
        }
      }
    }
    if (cards.length < 2) {
      return;
    }
    var max = 0;
    cards.forEach(function (card) {
      card.style.minHeight = "";
    });
    cards.forEach(function (card) {
      max = Math.max(max, card.offsetHeight);
    });
    if (max > 0) {
      cards.forEach(function (card) {
        card.style.minHeight = max + "px";
      });
    }
  });
}

function bwInitLoadMore() {
  document.querySelectorAll("[data-load-more]").forEach(function (btn) {
    var sel = btn.getAttribute("data-load-more");
    var step = parseInt(btn.getAttribute("data-step") || "6", 10);
    if (!sel || step < 1) {
      return;
    }
    var scope = btn.closest("section") || document;
    var items = scope.querySelectorAll(sel);
    if (!items.length) {
      btn.style.display = "none";
      return;
    }
    var shown = 0;
    function apply() {
      for (var i = 0; i < items.length; i++) {
        if (i < shown) {
          items[i].classList.remove("is-load-more-hidden");
          if (i >= step) {
            items[i].classList.add("aos-animate");
          }
        } else {
          items[i].classList.add("is-load-more-hidden");
        }
      }
      if (shown >= items.length) {
        var wrap = btn.closest(".bw_feature_page_btn, .bw_blog_page_btn, .bw_faq_page_btn, .bw_team_btn");
        if (wrap) {
          wrap.style.display = "none";
        } else {
          btn.style.display = "none";
        }
      }
    }
    shown = Math.min(step, items.length);
    apply();
    if (shown >= items.length) {
      return;
    }
    btn.addEventListener("click", function (e) {
      e.preventDefault();
      shown = Math.min(shown + step, items.length);
      apply();
      bwEqualizeBlogBoxes();
    });
  });
}

// bw_testimonial_section
  var swiper = bwMakeSwiper(".bw_testimonial_section .mySwiper", {
    slidesPerView: 1,
    spaceBetween: 0,
    loop: true,
    pagination: {
      el: ".bw_testimonial_section .swiper-pagination",
      type: "fraction",
    }
  });
// bw_testimonial_section

  var swiper = bwMakeSwiper(".bw_testimonial_content_slider .mySwiper", {
    loop: true, 
    spaceBetween: 0,
    slidesPerView: 1,
  // centeredSlides: true,
  // navigation: {
  //   nextEl: ".bw_testimonial_content_slider .swiper-button-next",
  //   prevEl: ".bw_testimonial_content_slider .swiper-button-prev",
  // },
    pagination: {
      el: ".swiper-pagination",
      dynamicBullets: true,
    },
   // freeMode: true,
  // watchSlidesProgress: true,

  });
  var swiper2 = bwMakeSwiper(".bw_testimonial_content_slider .mySwiper2", {
    loop: true,
    slidesPerView: 1,
    spaceBetween: 10,
    centeredSlides: true,
    navigation: {
      nextEl: ".bw_testimonial_content_slider .swiper-button-next",
      prevEl: ".bw_testimonial_content_slider .swiper-button-prev",
    },
    thumbs: swiper ? { swiper: swiper } : undefined,
    pagination: {
      el: ".swiper-pagination",
      dynamicBullets: true,
    },
    breakpoints: {
      575: {
        slidesPerView: 3,
        spaceBetween: 10,
      },
      991: {
        slidesPerView: 5,
        spaceBetween: 20,
      },
    },

  });




// bw_testimonial_two_section

  // var slider = new Swiper(".bw_testimonial_two_section .mySwiper", {
  //   loop: true,
  //   spaceBetween: 0,
  //   slidesPerView: 1,
  //   freeMode: false,
  //   watchSlidesProgress: false,
  //   pagination: {
  //     el: ".bw_testimonial_two_section .swiper-pagination",
  //     dynamicBullets: true,
  //   },
  //   centeredSlides: true,
  //   navigation: {
  //     nextEl: ".bw_testimonial_two_section .swiper-button-next",
  //     prevEl: ".bw_testimonial_two_section .swiper-button-prev",
  //   },
  // });
  // var thumbs = new Swiper(".bw_testimonial_two_section .mySwiper2", {
  //   loop: true,
  //   slidesPerView: 1,
  //   spaceBetween: 10,
  //   centeredSlides: true,
  //   slideToClickedSlide: true,
  //   thumbs: {
  //     swiper: swiper,
  //   },
  //   breakpoints: {
  //     575: {
  //       slidesPerView: 3,
  //       spaceBetween: 10,
  //     },
  //     991: {
  //       slidesPerView: 5,
  //       spaceBetween: 20,
  //     },
  //   },
  // });


  // slider.controller.control = thumbs;
  // thumbs.controller.control = slider;



  var testimonialThumbsEl = document.querySelector(".bw_testimonial_two_section .bw_testimonial_two_img");
  var testimonialMainEl = document.querySelector(".bw_testimonial_two_section .bw_testimonial_two_content");
  if (testimonialThumbsEl && testimonialMainEl && testimonialThumbsEl.querySelectorAll(".swiper-slide").length) {
    var thumbCount = testimonialThumbsEl.querySelectorAll(".swiper-slide").length;
    var thumbs = new Swiper(testimonialThumbsEl, {
      slidesPerView: Math.min(3, thumbCount),
      spaceBetween: 10,
      watchSlidesProgress: true,
      watchOverflow: true,
      breakpoints: {
        575: {
          slidesPerView: Math.min(3, thumbCount),
          spaceBetween: 10,
        },
        991: {
          slidesPerView: Math.min(5, thumbCount),
          spaceBetween: 20,
        },
      },
    });
    var testimonialMain = new Swiper(testimonialMainEl, {
      slidesPerView: 1,
      spaceBetween: 0,
      watchOverflow: true,
      pagination: {
        el: ".bw_testimonial_two_section .swiper-pagination",
        clickable: true,
        dynamicBullets: true,
      },
      navigation: {
        nextEl: ".bw_testimonial_two_section .swiper-button-next",
        prevEl: ".bw_testimonial_two_section .swiper-button-prev",
      },
      thumbs: {
        swiper: thumbs,
      },
    });
    Array.prototype.forEach.call(thumbs.slides, function (slide, index) {
      slide.addEventListener("click", function () {
        testimonialMain.slideTo(index);
        thumbs.slideTo(index);
      });
    });
    testimonialMain.on("slideChange", function () {
      thumbs.slideTo(testimonialMain.activeIndex);
    });
  }




  // bw_team_slider_section
  var swiper = bwMakeSwiper(".bw_team_slider_section .mySwiper", {
    spaceBetween: 0,
    slidesPerView: 1,
    pagination: {
      el: ".bw_team_slider_section .swiper-pagination",
      type: "fraction",
    },
    breakpoints: {
      "576": {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      "992": {
        slidesPerView: 3,
        spaceBetween: 20,
      },
    },
  });
// bw_team_slider_section

  // bw_blog_section
  var swiper = bwMakeSwiper(".bw_blog_section .mySwiper", {
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    navigation: {
      nextEl: ".bw_blog_section .swiper-button-next",
      prevEl: ".bw_blog_section .swiper-button-prev",
    },
    breakpoints: {
      575: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      991: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
    },
  });
  // bw_blog_section
   // bw_blog_section_two
  var swiper = bwMakeSwiper(".bw_blog_section_two .mySwiper", {
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    navigation: {
      nextEl: ".bw_blog_section_two .swiper-button-next",
      prevEl: ".bw_blog_section_two .swiper-button-prev",
    },
    breakpoints: {
      575: {
        slidesPerView: 1,
        spaceBetween: 20,
      },
      767: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
      1199: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
    },
  });
  // bw_blog_section

  // svg_line_repetar
  if (!customElements.get("svg-path-elements")) customElements.define(
    "svg-path-elements",
    class extends HTMLElement {
      connectedCallback() {
        let id = "curve" + this.getAttribute("id");
        let speed = 1;
        let position = 0;
        let count = Math.min(Math.max(~~this.getAttribute("count") || 4, 1), 6);
        let elements = Array(count)
        .fill(0)
        .map((_, idx, arr) => {
          let inlineFunctionOnEnd = `this.closest('svg').parentNode.onend(${idx})`;
          let circle = `<svg id="circle${idx}" width="1147" height="412" viewBox="0 0 1147 412" fill="none">
          <path  d="M0.906792 411.22C53.9068 360.554 222.607 268.42 473.407 305.22C663.907 347.22 1041.91 316.72 1145.91 0.720215" stroke="#2C3333" stroke-opacity="0.15" stroke-width="0.965779"/>
          </svg>`;
          position += 1 / (arr.length - 1);
          return circle;
        })
        .join("");
        this.innerHTML = `<svg width="1147" height="412" viewBox="0 0 1147 412" fill="none">
        <path id="${id}" d="M0.906792 411.22C53.9068 360.554 222.607 268.42 473.407 305.22C663.907 347.22 1041.91 316.72 1145.91 0.720215" stroke="#2C3333" stroke-opacity="0.15" stroke-width="0.965779"/>
        </svg>${elements}`;
      }
      onend(idx) {
        let circle = this.querySelector("#circle" + idx);
      }
    }
    );
  // svg_line_repetar

  // create_page_url_in_body_class
  var URL = window.location.pathname;
  var page = URL.split("/").pop().split(".").shift();
  jQuery("body").addClass(page);
  // create_page_url_in_body_class

  // bw_header
    jQuery(window).scroll(function () {
      if (jQuery(this).scrollTop() > 0) {
        jQuery(".bw_header, .bw_header_two").addClass("bw_sticky");
      } else {
        jQuery(".bw_header, .bw_header_two").removeClass("bw_sticky");
      }
    });

    $(".bw_drop_down_wrap").click(function () {
      $(".bw_drop_down_wrap .bw_dropdown_menu").slideToggle();
      $(this).toggleClass("active");
    });

    function setMenuOpen($panel, open) {
      if (!$panel.length) {
        return;
      }
      if (open) {
        $panel.addClass("open").attr("aria-hidden", "false").removeAttr("inert");
      } else {
        $panel.removeClass("open").attr("aria-hidden", "true").attr("inert", "");
      }
    }

    jQuery(".bw_header .bw_mobile_menu_open").on("click", function () {
      var $panel = jQuery("#bw-menubar");
      setMenuOpen($panel, true);
      jQuery(this).attr("aria-expanded", "true");
      jQuery(".bw_menubar_close").trigger("focus");
    });
    jQuery(".bw_menubar_close").on("click", function () {
      setMenuOpen(jQuery("#bw-menubar"), false);
      jQuery(".bw_header .bw_mobile_menu_open").attr("aria-expanded", "false").trigger("focus");
    });

    jQuery(".bw_header_two .bw_mobile_menu_open").on("click", function () {
      jQuery(".bw_header_two").addClass("open");
      var $panel = jQuery("#bw-mobile-menu");
      $panel.attr("aria-hidden", "false").removeAttr("inert");
      jQuery(this).attr("aria-expanded", "true");
      jQuery(".bw_header_two .bw_mobile_menu_closer").trigger("focus");
    });
    jQuery(".bw_header_two .bw_mobile_menu_closer").on("click", function () {
      jQuery(".bw_header_two").removeClass("open");
      jQuery("#bw-mobile-menu").attr("aria-hidden", "true").attr("inert", "");
      jQuery(".bw_header_two .bw_mobile_menu_open").attr("aria-expanded", "false").trigger("focus");
    });

    // Keyboard + click desktop dropdowns (hover still works as progressive enhancement)
    jQuery(".bw_header_dropdown > .bw_dropdown_hover").on("click", function (e) {
      e.preventDefault();
      var $li = jQuery(this).closest(".bw_header_dropdown");
      var open = !$li.hasClass("is-open");
      jQuery(".bw_header_dropdown").removeClass("is-open");
      jQuery(".bw_dropdown_hover").attr("aria-expanded", "false");
      if (open) {
        $li.addClass("is-open");
        jQuery(this).attr("aria-expanded", "true");
      }
    });
    jQuery(document).on("keydown", function (e) {
      if (e.key === "Escape") {
        jQuery(".bw_header_dropdown").removeClass("is-open");
        jQuery(".bw_dropdown_hover").attr("aria-expanded", "false");
        setMenuOpen(jQuery("#bw-menubar"), false);
        jQuery(".bw_header .bw_mobile_menu_open").attr("aria-expanded", "false");
        jQuery(".bw_header_two").removeClass("open");
        jQuery("#bw-mobile-menu").attr("aria-hidden", "true").attr("inert", "");
        jQuery(".bw_header_two .bw_mobile_menu_open").attr("aria-expanded", "false");
      }
    });

  // bw_header

    


    jQuery("ul.tabs li").click(function () {
      var tab_id = jQuery(this).attr("data-tab");

      jQuery("ul.tabs li").removeClass("current");
      jQuery(".tab-content").removeClass("current");

      jQuery(this).addClass("current");
      jQuery("#" + tab_id).addClass("current");
    });

    //===== start accordian js =====//

    jQuery("body").on("click", ".accordion .accordion-tabs", function () {
      console.log('fgf');
      jQuery(".accordion-content").slideUp(),
      jQuery(this).hasClass("acco-active")
      ? (jQuery(this).next(".accordion-content").slideUp(),
        jQuery(this).removeClass("acco-active"))
       //jQuery('.accordion-item').removeClass('bw-active-tab'),
        //jQuery(this).parent().addClass('bw-active-tab'),
      : (jQuery(".accordion .accordion-tabs").removeClass("acco-active"),
        jQuery('.accordion-item').removeClass('bw-active-tab'),
        jQuery(this).parent().addClass('bw-active-tab'),
        jQuery(this).addClass("acco-active"),
        jQuery(this).next(".accordion-content").slideDown());
      jQuery(".accordion .accordion-tabs h5 span.accordion_icon").text("add");
      jQuery(
        ".accordion .accordion-tabs.acco-active h5 span.accordion_icon"
        ).text("remove");

      jQuery(".bw_faq_page_section_2 .accordion .accordion-tabs h5 span.accordion_icon").text("expand_more");
      jQuery(
        ".bw_faq_page_section_2 .accordion .accordion-tabs.acco-active h5 span.accordion_icon"
        ).text("expand_less");

    });

    //===== End accordian js =====//

    //===== start accordian add class js =====//

    jQuery(".accordion-tabs.acco-active").parent().addClass('bw-active-tab');

    //===== End accordian add class js =====//



    $(".bw_custom_popup").magnificPopup({
      type: "inline",
      preloader: false,
    });


    // Card detail popup removed — hero card is decorative only.
    if (jQuery.fn.counterUp && $(".counter").length) {
      $(".counter").counterUp({
        delay: 10,
        time: 500,
      });
      $(".counter").addClass("animated fadeInDownBig");
    }
    $(".bw_hero_card h3").addClass("animated fadeIn");

    //===== start all animation js =====//

    document.querySelectorAll("[data-aos-duration]").forEach(function (el) {
      if (parseInt(el.getAttribute("data-aos-duration"), 10) > 700) {
        el.setAttribute("data-aos-duration", "600");
      }
    });
    AOS.init({
      once: true,
      duration: 600,
      disable: window.matchMedia("(prefers-reduced-motion: reduce)").matches
    });
    bwInitLoadMore();
    bwEqualizeBlogBoxes();
    window.addEventListener("load", bwEqualizeBlogBoxes);
    window.addEventListener("resize", function () {
      window.clearTimeout(window.bwBlogBoxTimer);
      window.bwBlogBoxTimer = window.setTimeout(bwEqualizeBlogBoxes, 150);
    });

    //===== End all animation js =====//

    var CurrentUrl = document.URL;
    var CurrentUrlEnd = CurrentUrl.split("/").filter(Boolean).pop();
    $(".bw_all_menu li a").each(function () {
      var ThisUrl = $(this).attr("href");
      var ThisUrlEnd = ThisUrl.split("/").filter(Boolean).pop();

      if (ThisUrlEnd == CurrentUrlEnd) {
        $(this).closest("li").addClass("current_page_active");
      }
    });
  });


$(document).ready(function () {
  // start_after_and_before_slider
  // start_after_and_before_slider
  if (window.jQuery && jQuery.fn.magnificPopup) {
    jQuery(".js-video-modal").magnificPopup({
      type: "inline",
      midClick: true,
      closeBtnInside: true,
      removalDelay: 200,
      mainClass: "bw-video-mfp",
      callbacks: {
        open: function () {
          var preview = document.querySelector(".bw_video_Slider video");
          if (preview) {
            preview.pause();
          }
          var video = this.content.find("video").get(0);
          if (video) {
            video.currentTime = 0;
            var playPromise = video.play();
            if (playPromise && typeof playPromise.catch === "function") {
              playPromise.catch(function () {});
            }
          }
        },
        close: function () {
          var video = this.content.find("video").get(0);
          if (video) {
            video.pause();
            video.currentTime = 0;
          }
        },
      },
    });
  }

  jQuery(".bw_video_Slider .before").on("click", function (e) {
    if (jQuery(e.target).closest(".js-video-modal, a, button").length) {
      return;
    }
    var trigger = jQuery(this).closest(".bw_video_section").find(".js-video-modal").first();
    if (!trigger.length) {
      trigger = jQuery(".js-video-modal").first();
    }
    if (trigger.length) {
      e.preventDefault();
      trigger.trigger("click");
    }
  });

  var videoSlider = document.querySelector(".bw_video_Slider");
  var scroller = document.querySelector(".bw_video_Slider .scroller");
  var after = document.querySelector(".bw_video_Slider .after");
  if (videoSlider && scroller && after) {
  let active = false;

  scroller.addEventListener("mousedown", function () {
    active = true;
    scroller.classList.add("scrolling");
  });
  document.body.addEventListener("mouseup", function () {
    active = false;
    scroller.classList.remove("scrolling");
  });
  document.body.addEventListener("mouseleave", function () {
    active = false;
    scroller.classList.remove("scrolling");
  });

  document.body.addEventListener("mousemove", function (e) {
    if (!active) return;
    let x = e.pageX;
    x -= videoSlider.getBoundingClientRect().left;
    scrollIt(x);
  });

  function scrollIt(x) {
    let transform = Math.max(
      0,
      Math.min(x, videoSlider.offsetWidth)
      );
    after.style.width = transform + "px";
    scroller.style.left = transform - 16 + "px";
  }

  scrollIt(videoSlider.offsetWidth / 2);

  scroller.addEventListener("touchstart", function () {
    active = true;
    scroller.classList.add("scrolling");
  });

  document.body.addEventListener("touchend", function () {
    active = false;
    scroller.classList.remove("scrolling");
  });

  document.body.addEventListener("touchcancel", function () {
    active = false;
    scroller.classList.remove("scrolling");
  });
  }

  // end_after_and_before_slider
  // end_after_and_before_slider

  // Decorative home hero card — flip only; no card-detail inputs (Rule 10).
  window.onload = function () {
    var preload = document.querySelector(".bw_hero_custom_card.preload");
    if (preload) {
      preload.classList.remove("preload");
    }
    var card = document.querySelector(".bw_hero_card .creditcard");
    if (!card) {
      return;
    }
    card.addEventListener("click", function () {
      this.classList.toggle("flipped");
    });
    card.addEventListener("keydown", function (e) {
      if (e.key === "Enter" || e.key === " ") {
        e.preventDefault();
        this.classList.toggle("flipped");
      }
    });
    if (!card.hasAttribute("tabindex")) {
      card.setAttribute("tabindex", "0");
      card.setAttribute("role", "button");
      card.setAttribute("aria-label", "Flip decorative bank card");
    }
  };



  







  
});
