$(document).ready(function () {
  // navigation click actions
  $(".scroll-link").on("click", function (event) {
    event.preventDefault();
    var sectionID = $(this).attr("data-id");
    scrollToID("#" + sectionID, 750);
  });
  // scroll to top action
  $(".scroll-top").on("click", function (event) {
    event.preventDefault();
    $("html, body").animate({
      scrollTop: 0
    }, "slow");
  });
  // mobile nav toggle
  $("#nav-toggle").on("click", function (event) {
    event.preventDefault();
    $("#main-nav").toggleClass("open");
  });
});

// scroll function
function scrollToID(id, speed) {
  var offSet = 50;
  var targetOffset = $(id).offset().top - offSet;
  var mainNav = $("#main-nav");
  $("html,body").animate({
    scrollTop: targetOffset
  }, speed);
  if (mainNav.hasClass("open")) {
    mainNav.css("height", "1px").removeClass("in").addClass("collapse");
    mainNav.removeClass("open");
  }
}
if (typeof console === "undefined") {
  console = {
    log: function () {}
  };
}

window.onload = function () {
  var SHOW_CLASS = "show",
    HIDE_CLASS = "hide",
    ACTIVE_CLASS = "active";

  $(".tabs").on("click", "li a", function (e) {
    e.preventDefault();
    var $tab = $(this),
      href = $tab.attr("href");

    $(".active").removeClass(ACTIVE_CLASS);
    $tab.addClass(ACTIVE_CLASS);

    $(".show").removeClass(SHOW_CLASS).addClass(HIDE_CLASS).hide();

    $(href).removeClass(HIDE_CLASS).addClass(SHOW_CLASS).hide().fadeIn(550);
  });
  $(".form").find("input, textarea").on("keyup blur focus", function (e) {
    var $this = $(this),
      label = $this.prev("label");

    if (e.type === "keyup") {
      if ($this.val() === "") {
        label.removeClass("active highlight");
      } else {
        label.addClass("active highlight");
      }
    } else if (e.type === "blur") {
      if ($this.val() === "") {
        label.removeClass("active highlight");
      } else {
        label.removeClass("highlight");
      }
    } else if (e.type === "focus") {
      if ($this.val() === "") {
        label.removeClass("highlight");
      } else if ($this.val() !== "") {
        label.addClass("highlight");
      }
    }
  });

  $(".tab a").on("click", function (e) {
    e.preventDefault();

    $(this).parent().addClass("active");
    $(this).parent().siblings().removeClass("active");

    target = $(this).attr("href");

    $(".tab-content > div").not(target).hide();

    $(target).fadeIn(600);
  });
};
