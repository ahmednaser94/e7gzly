
$.ajax(`../api.php?section=contacts&do=get_contacts`, {
    method: `POST`,
    data: {
    },
    success: function (data, textStatus, jqXHR) {
        if (data == 'false') {
        $('#contacts_button').val('add');
        $('#contacts_button').html('Add');
        }
        else{
          contacts = JSON.parse(data);
          $('#phone_contact').html(contacts.phone);
          $('#email_contact').html(contacts.email);
          $('#fb').attr("href",contacts.fb);
          $('#twitter').attr("href",contacts.twitter);
          $('#instagram').attr('href',contacts.instagram);
          $('#youtube').attr("href",contacts.youtube);
          $('#linkedin').attr("href",contacts.linkedin);
        }
  
    },
    error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
    }
  })
  

  $.ajax(`../api.php?section=about_us&do=get_about_us`, {
    method: `POST`,
    data: {
    },
    success: function (data, textStatus, jqXHR) {
        if (data == 'false') {
        $('.about_us').html('There is no about us yet!')
        $('#about_button').val('add');
        $('#about_button').html('Add');
        }
        else{
          About = JSON.parse(data);
          $('.about_us_body').html(About.details);
        }

    },
    error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
    }
})


  $.ajax(`../api.php?section=about_us&do=statistics`, {
    method: `POST`,
    data: {
    },
    success: function (data, textStatus, jqXHR) {
        if (data == 'false') {
          $('.serve').hide();
        }
        else{
          stat = JSON.parse(data);
          $("#org_count").attr("data-number",stat.organizations);
          $("#customers_count").attr("data-number",stat.customers);
          $("#tickets_count").attr("data-number",stat.tickets);
        }

    },
    error: function (jqXhr, textStatus, errorThrown) {
        console.log(errorThrown);
    }
})