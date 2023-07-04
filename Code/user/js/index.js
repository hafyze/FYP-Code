function fetchPromotionData() {
    $.ajax({
      url: '../php/promotion.php',
      type: 'GET',
      dataType: 'json',
      success: function(data) {
        // Display the promotion data in the promotion section
        var promotionSection = document.querySelector('#promotion');
        var html = '<h1>Promotion</h1>';
  
        if (data.length > 0) {
          for (var i = 0; i < data.length; i++) {
            var promotion = data[i];
            html += '<div class="promotionItem">';
            html += '<h2>' + promotion.promo_condition + '</h2>';
            html += '<p>Discount: ' + promotion.discount + '</p>';
            html += '<p>Start Date: ' + promotion.starting_date + '</p>';
            html += '<p>End Date: ' + promotion.end_date + '</p>';
            html += '</div>';
          }
        } else {
          html += '<p>No promotions available.</p>';
        }
  
        promotionSection.innerHTML = html;
      },
      error: function() {
        console.log('Error occurred while fetching promotion data.');
      }
    });
  }
  
  // Call the fetchPromotionData function to load the promotion data on page load
  $(document).ready(function() {
    fetchPromotionData();
});