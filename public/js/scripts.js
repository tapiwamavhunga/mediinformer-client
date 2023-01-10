//  Preloader
jQuery(window).on("load", function () {
  $("#preloader").fadeOut(500);
  $("#main-wrapper").addClass("show");
});

(function ($) {
  "use strict";

  //to keep the current page active
  //to keep the current page active
  // Setting active
  $(function () {
    const settings = window.location.pathname.includes("settings");
    if (settings) {
      $(".setting_").addClass("active");
    }
  });
  // active sidebar
  $(function () {
    for (
      var nk = window.location,
        o = $(".menu a")
          .filter(function () {
            return nk.href.includes(this.href);
          })
          .addClass("active")
          .parent()
          .addClass("active");
      ;

    ) {
      // console.log(o)
      if (!o.is("li")) break;
      o = o.parent().addClass("show").parent().addClass("active");
    }
  });
  // Setting sidebar
  $(function () {
    for (
      var nk = window.location,
        o = $(".settings-menu a")
          .filter(function () {
            return nk.href.includes(this.href);
          })
          .addClass("active")
          .parent()
          .addClass("active");
      ;

    ) {
      // console.log(o)
      if (!o.is("li")) break;
      o = o.parent().addClass("show").parent().addClass("active");
    }
  });

  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
  let year = document.querySelector("#year");
  if (year) {
    year.innerHTML = new Date().getFullYear();
  }
  const value = "https://www.Tende.io/join/12345";
  const copy = document.querySelectorAll(".copy");
  copy.forEach((c) => {
    c.addEventListener("click", () => {
      navigator.clipboard.writeText(value);
      alert("Copied the text: " + value);
    });
  });
})(jQuery);


// require('./bootstrap');
(function ($) {
  "use strict";

  /**
   * All of the code for your public-facing JavaScript source
   * should reside in this file.
   *
   * Note: It has been assumed you will write jQuery code here, so the
   * $ function reference has been prepared for usage within the scope
   * of this function.quickaction-email
   *
   * This enables you to define handlers, for when the DOM is ready:
   *
   * $(function() {
   *
   * });
   *
   * When the window is loaded:
   *
   * $( window ).load(function() {
   *
   * });
   *
   * ...and/or other possibilities.
   *
   * Ideally, it is not considered best practise to attach more than a
   * single DOM-ready or window-load handler for a particular page.
   * Although scripts in the WordPress core, Plugins and Themes may be
   * practising this, we should strive to set a better example in our own work.
   */
  console.log("public jquery");

  function getFormData($form) {
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function (n, i) {
      indexed_array[n["name"]] = n["value"];
    });

    return indexed_array;
    quickaction - email;
  }

  var vals = "";

  $(document).ready(function () {
    $(".brochure_email_button").on("click", function () {
      $(".sms-collection").slideUp("slow");
      $(".brochure_sms_button").fadeOut("fast");
      $(".brochure_whatsapp_button").fadeOut("fast");
      $(this).fadeOut("fast");
      $(".brochure-searchpage-results").slideUp("slow", function () {
        $(".email-collection").slideDown("slow");
        $('.email-collection').css("display", "block")
      });
      
    });



    $(".brochure_sms_button").on("click", function () {
      $(".email-collection").slideUp("slow");
      $(".brochure_email_button").fadeOut("fast");
      $(".brochure_whatsapp_button").fadeOut("slow");

      $(this).fadeOut("fast");
      $(".brochure-searchpage-results").slideUp("slow", function () {
        $(".sms-collection").slideDown("slow");
      });
    });

      $(".brochure_whatsapp_button").on("click", function () {
      $(".email-collection").slideUp("slow");
      $(".brochure_email_button").fadeOut("fast");
      $(".brochure_sms_button").fadeOut("fast");

      $(this).fadeOut("fast");
      $(".brochure-searchpage-results").slideUp("slow", function () {
        $(".whatsapp-collection").slideDown("slow");
      });
    });

    $(document).on("click", ".backtobrochures", function () {
      $(".brochure-categories-results, .brochure-searchpage-results").slideUp(
        "slow",
        function () {
          setTimeout(function () {
            $(".listing-group").slideDown("slow");
          }, 1000);
        }
      );
    });
    $(".brochure-categories").hide();
    $(".listing-group-filter-select select").on("change", function () {
      $(".brochure-groups, .brochure-categories, .brochure-postscripts").hide();
      var val = $(this).find("option:selected").val();
      if (val == 0) {
        $(".brochure-item").hide();
        $(".brochure-item.prescript").show();
        $(".brochure-groups").fadeIn();
      }
      if (val == 1) {
        $(".brochure-categories").fadeIn();
      }
      if (val == 2) {
        $(".brochure-item").hide();
        $(".brochure-item.postscript").show();
        $(".brochure-groups").fadeIn();
      }
    });

    $(document).on("click", ".chosenbrochure", function () {
      var brochureid = $(this).attr("id");
      console.log(brochureid);
      //console.log(vals);
      vals = vals.replace(brochureid + ",", "");
      $("#" + brochureid).remove();
     // console.log(vals);
      $(".medclient_portfolio_chosen").each(function () {
        if ($(this).attr("data-id") == brochureid) {
          $(this).prop("checked", false);
        }
      });
    });

    $(document).on("change", ".medclient_portfolio_chosen", function () {
      var brochuretitle = $(this).attr("data-title");
      var brochureid = $(this).attr("data-id");
      var post = $(this).attr("data-post");
      var content = $(this).attr("data-content");
      var datahref = $(this).attr("data-href");
      $(".brochure-collection-items .no-results").slideUp("slow");
      if ($(this).prop("checked")) {
        $(".brochure-collection-items").append(
          '<span id="' +
            brochureid +
            '" class="chosenbrochure mc-animate">' +
            brochuretitle +
            ' <span class="close">&times;</span></span>'
        );

        vals += brochureid + ",";
        $(".data_post").val(post);
        $(".data_content").val(content);
        console.log("pres", content);

        content = JSON.parse(content);
        console.log("pres", content);
        if (content) {
          $(".postscript_passcode").val(content.postscript_passcode);
          $(".postscript").val(content.postscript);
        }

        $(".data_href").val(datahref);
      } else {
        vals = vals.replace(brochureid + ",", "");
        $("#" + brochureid).remove();
        $(".data_post").val("");
        $(".data_content").val("");
        $(".data_href").val("");
      }
      //console.log(vals);
      $(".brochure_ids").val(vals);
      $(".brochure-collection-button").show();
      $(".brochure-collection").slideDown("slow");
      $(".brochure_email_button, .brochure_sms_button").slideDown("slow");
      $(".brochure_sms_button").slideDown("slow");
      $(".brochure_whatsapp_button").slideDown("slow");
    });

    $("#searchbrochuresform").on("submit", function (e) {
      e.preventDefault();
      $(".brochure-collection-button button").show();
      $(
        ".brochure-searchpage-results, .listing-group, .brochure-categories-results, .email-collection"
      ).slideUp("slow");
      $(".brochure_search_button").addClass("active");
      var formData = getFormData($(this));

       $.post({
        type: "POST",
        url: '/brochuresearch',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            'data': formData
        }},


        function (response) {
        //console.log(response);

          $(".brochure-searchpage-results").html(response);
          $(".brochure-searchpage-results").slideDown("slow", function () {
            $(".brochure-collection-items").slideDown("slow");
            $(".brochure_search_button").removeClass("active");
          });
        }
      );
    });

    $("div.brochure-item").on("click", function () {
      var bid = $(this).attr("data-bid");
      var authorid = $('input[name="page_author_id"]').val();
      console.log("search page author:" + authorid);
      console.log("brochure:" + bid);
      $(
        ".brochure-searchpage-results, .brochure-categories-results, .listing-group"
      ).slideUp("slow", function () {
        $(".brochure-categories-loading").fadeIn("fast", function () {
          $.post({
        type: "POST",
        url: '/brochurefetch',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

        data: {
            'userid': authorid,
            'data': bid
        }},
            function (response) {
              console.log(response);
              $(".brochure-categories-loading").fadeOut("fast");
              $(".brochure-categories-results").html(response);
              $(".brochure-categories-results").slideDown("fast", function () {
                $(".brochure-collection-items").slideDown("slow");
              });
            }
          );
        });
      });
    });

    $(".brochure-category").on("click", function () {
      var catid = $(this).attr("data-id");
      var authorid = $('input[name="page_author_id"]').val();
      console.log("search page author:" + authorid);
      console.log("category:" + catid);
      $(
        ".brochure-searchpage-results, .brochure-categories-results, .listing-group"
      ).slideUp("slow", function () {
        $(".brochure-categories-loading").fadeIn("fast", function () {
        $.post({
        type: "GET",
        url: '/brochurecategory',
        data: {
            'userid': authorid,
            'data': catid
        }},
            function (response) {
              // console.log(response);
              $(".brochure-categories-loading").fadeOut("fast");
              $(".brochure-categories-results").html(response);
              $(".brochure-categories-results").slideDown("fast", function () {
                $(".brochure-collection-items").slideDown("slow");
              });
            }
          );
        });
      });
    });

    $(document).on("click", ".brochure-category-item", function () {
      var catid = $(this).attr("data-catid");
      var authorid = $('input[name="page_author_id"]').val();

      $(".brochure-searchpage-results, .brochure-categories-results").slideUp(
        "slow",
        function () {
          $(".brochure-categories-loading").fadeIn("fast", function () {
            console.log("search page author:" + authorid);
            console.log("category:" + catid);
            // $.post(
            //   ajax.url,
            //   {
            //     action: "brochurecategory",
            //     userid: authorid,
            //     data: catid,
            //   },

             $.post({
        type: "POST",
        url: '/brochurecategory',
        data: {
            'userid': authorid,
            'data': catid
        }},
              function (response) {
                // console.log(response);
                $(".brochure-categories-loading").fadeOut("fast");
                $(".brochure-categories-results").html(response);
                $(".brochure-categories-results").slideDown("fast");
              }
            );
          });
        }
      );

      /*$.post(
          ajax.url,
          {
              'action': 'brochurecategory',
          'userid':
              'data':   catid
          },
          function(response) {
              console.log(response);

          $('.brochure-searchpage-results').html(response);
          $('.brochure-searchpage-results').slideDown('slow', function(){
            $('.brochure-collection-items').slideDown('slow');
            $('.brochure_search_button').removeClass('active');
          });

          }
      );*/
    });

    $(document).on("submit", "#emailbrochuresform", function (e) {
      e.preventDefault();
      console.log("email brochures");

      var formData = getFormData($(this));

      $(
        ".brochure-collection-items, .email-collection, .brochure-categories-results"
      ).slideUp("slow");

      $(".brochure-email-loading").slideDown("slow");

      setTimeout(function () {
        emailBrochures(formData);
      }, 1000);
    });

    $(document).on("submit", "#modalemailbrochuresform", function (e) {
      e.preventDefault();
      console.log("email modal brochures");

      var formData = getFormData($(this));

      $(".modal-body .brochure-email-loading").slideDown("slow");
      $("#modalemailbrochuresform").slideUp("slow");

      setTimeout(function () {
        emailModalBrochures(formData);
      }, 1000);
    });

    $(document).on("submit", "#smsbrochuresform", function (e) {
      e.preventDefault();

      var formData = getFormData($(this));

      $("#smsBrochureModal .close").click();
      $(
        ".brochure-collection-items, .sms-collection, .brochure-categories-results"
      ).slideUp("slow");

      $(".brochure-sms-loading").slideDown("slow");

      setTimeout(function () {
        smsBrochures(formData);
      }, 1000);
    });

    $(document).on("submit", "#modalsmsbrochuresform", function (e) {
      e.preventDefault();

      var formData = getFormData($(this));
      //console.log(formData);
      //$("#smsBrochureModal .close").click();
      $(".modal-body .brochure-sms-loading").slideDown("slow");
      $("#modalsmsbrochuresform").slideUp("slow");

      setTimeout(function () {
        smsModalBrochure(formData);
      }, 1000);
    });


     $(document).on("submit", "#whatsappbrochuresform", function (e) {
      e.preventDefault();

      var formData = getFormData($(this));

      $("#whatsappBrochureModal .close").click();
      $(
        ".brochure-collection-items, .whatsapp-collection, .brochure-categories-results"
      ).slideUp("slow");

      $(".brochure-whatsapp-loading").slideDown("slow");

      setTimeout(function () {
        whatsappBrochures(formData);
      }, 1000);
    });

    $(document).on("submit", "#modalwhatsappbrochuresform", function (e) {
      e.preventDefault();

      var formData = getFormData($(this));
      //console.log(formData);
      //$("#smsBrochureModal .close").click();
      $(".modal-body .brochure-whatsapp-loading").slideDown("slow");
      $("#modalwhatsappbrochuresform").slideUp("slow");

      setTimeout(function () {
        whatsappModalBrochure(formData);
      }, 1000);
    });




    $(document).on("click", ".quickaction-sms", function (e) {
      e.preventDefault();
      var parent = $(this).parent();
      var bid =
        $(this).parent().find(".medclient_portfolio_chosen").attr("data-id") +
        ",";

      $("#smsBrochureModal input.brochure_ids").val(bid);
      //   var post = $(this).attr("data-post");
      var content = $(this).attr("data-content");
      content = JSON.parse(content);
      $("#smsBrochureModal input.postscript").val(content["postscript"]);
      $("#smsBrochureModal input.postscript_passcode").val(
        content["postscript_passcode"]
      );

      $("#smsBrochureModal").modal("toggle");
    });

    $(document).on("click", ".quickaction-email", function (e) {
      e.preventDefault();
      console.log("clicked");
      var parent = $(this).parent();
      var bid =
        $(this).parent().find(".medclient_portfolio_chosen").attr("data-id") +
        ",";

      $("#emailBrochureModal input.brochure_ids").val(bid);
      var post = $(this).attr("data-post");
      var content = $(this).attr("data-content");
      content = JSON.parse(content);
      var url = $(this).attr("href");

      //$.post(
        // url,
        // {
        //   action: "get_email",
        //   post: post,
        //   postscript_passcode: content["postscript_passcode"],
        //   postscript: content["postscript"],
        // },

          $.post({
        type: "GET",
        url: '/get_email',
        data: {
            'postscript_passcode': postscript_passcode,
            'post': post,
            'postscript': content["postscript"],
        }},

        function (data) {
          $("#emailTextarea").html(data);
          $("#emailBrochureModal").modal("toggle");
        }
      );

      // $('#emailBrochureModal').modal('toggle');
    });

    $(".formfield").focusin(function () {
      $(this).find(".formfield-label").addClass("mcshrink");
    });
    $(".formfield").focusout(function () {
      var fieldvalue = $(this).find("input").val();
      if (fieldvalue === "") {
        $(this).find(".formfield-label").removeClass("mcshrink");
      }
    });
  });

  function emailBrochures(formData) {
    console.log(formData);

    $.post({
        type: "POST",
        url: '/brochureemail',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            'data': formData
        }},



    // $.post(
    //   ajax.url,
    //   {
    //     action: "brochureemail",
    //     data: formData,
    //   },
      function (response) {
        //console.log(response);
        vals = "";
        $(".brochure_ids").val("");
        $(".chosenbrochure").remove();
        $(".brochure-searchpage-results").html(response);
        $(".brochure-email-loading").slideUp("slow", function () {
          $(".brochure-searchpage-results").slideDown("slow");
        });
      }
    );
  }
  function emailModalBrochures(formData) {
    console.log(formData);
    $.post(
      ajax.url,
      {
        action: "brochureemail",
        data: formData,
      },
      
      function (response) {
        vals = "";
        $(".brochure-email-results .brochure-email-results-text").html(
          response
        );
        $(".modal-body .brochure-email-loading").slideUp("slow", function () {
          $(".modal-body .brochure-email-results").slideDown("slow");
          $("#modalemailbrochuresform").slideDown("slow");
        });

        setTimeout(function () {
          $(".modal-body .brochure-email-results").slideUp("slow");
        }, 3000);
      }
    );
  }
  function smsBrochures(formData) {
    console.log("sms brochures");
    console.log(formData);
    // $.post(
    //   ajax.url,
    //   {
    //     action: "brochuresms",
    //     data: formData,
    //   },

      $.post({
        type: "POST",
        url: '/brochuresms',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            'data': formData
        }},
      function (response) {
        console.log(response);
        vals = "";
        $(".brochure_ids").val("");
        $(".chosenbrochure").remove();
        $(".brochure-searchpage-results").html(response);
        $(".brochure-sms-loading").slideUp("slow", function () {
          $(".brochure-searchpage-results").slideDown("slow");
        });
      }
    );
  }
  function smsModalBrochure(formData) {
    console.log("sms modal brochure");
    console.log(formData);
    $.post(
      ajax.url,
      {
        action: "brochuresms",
        data: formData,
      },
      function (response) {
        vals = "";
        $(".brochure-sms-results .brochure-sms-results-text").html(response);
        $(".modal-body .brochure-sms-loading").slideUp("slow", function () {
          $(".modal-body .brochure-sms-results").slideDown("slow");
          $("#modalsmsbrochuresform").slideDown("slow");
        });

        setTimeout(function () {
          $(".modal-body .brochure-sms-results").slideUp("slow");
        }, 3000);
      }
    );
  }


  function whatsappBrochures(formData) {
    console.log("whatsapp brochures");
    console.log(formData);
    // $.post(
    //   ajax.url,
    //   {
    //     action: "brochuresms",
    //     data: formData,
    //   },

      $.post({
        type: "POST",
        url: '/brochurewhatsapp',
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: {
            'data': formData
        }},
      function (response) {
        console.log(response);
        vals = "";
        $(".brochure_ids").val("");
        $(".chosenbrochure").remove();
        $(".brochure-searchpage-results").html(response);
        $(".brochure-whatsapp-loading").slideUp("slow", function () {
          $(".brochure-searchpage-results").slideDown("slow");
        });
      }
    );
  }
  function whatsappModalBrochure(formData) {
    console.log("whatsapp modal brochure");
    console.log(formData);
    $.post(
      ajax.url,
      {
        action: "brochurewhatsapp",
        data: formData,
      },
      function (response) {
        vals = "";
        $(".brochure-whatsapp-results .brochure-whatsapp-results-text").html(response);
        $(".modal-body .brochure-whatsapp-loading").slideUp("slow", function () {
          $(".modal-body .brochure-whatsapp-results").slideDown("slow");
          $("#modalwhatsappbrochuresform").slideDown("slow");
        });

        setTimeout(function () {
          $(".modal-body .brochure-whatsapp-results").slideUp("slow");
        }, 3000);
      }
    );
  }
})(jQuery);
