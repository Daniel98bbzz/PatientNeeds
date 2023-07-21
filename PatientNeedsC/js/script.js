document.addEventListener("DOMContentLoaded", function() {
  var tableRows = document.querySelectorAll("tbody tr");

  tableRows.forEach(function(row) {
    var action1 = row.querySelector(".action-1");
    var icon1 = action1.querySelector(".action-icon");

    var action2 = row.querySelector(".action-2");
    var icon2 = action2.querySelector(".action-icon");

    action1.addEventListener("click", function() {
      this.classList.toggle("active");
      icon1.classList.toggle("red");
    });

    action2.addEventListener("click", function() {
      this.classList.toggle("active");
      icon2.classList.toggle("red");
    });
  });
});
/*************************this is the left card */
fetch('fetch_data.php')
  .then(response => response.json())
  .then(data => {

    const xValues = data.map(item => item.hour);
    const yValues = data.map(item => item.count);


    const xValuesStr = xValues.map(hour => {
      return `${hour.toString().padStart(2, '0')}:00`; 
    });

    new Chart("myChart", {
      type: "line",
      data: {
        labels: xValuesStr,
        datasets: [{
          label: "Smart Call by Hour",
          fill: false,
          lineTension: 0,
          backgroundColor: "rgba(0,0,255,1.0)",
          borderColor: "rgba(0,0,255,0.1)",
          data: yValues
        }]
      },
      options: {
        legend: {display: false},
        scales: {
          yAxes: [{ticks: {min: 6, max:16}}],
        }
      }
    });
  });



/* right card----*/
fetch('fetch_data2.php')
  .then(response => response.json())
  .then(data => {

    const x2Values = data.map(item => item.hour);
    const y2Values = data.map(item => item.count);

    
    const x2ValuesStr = x2Values.map(hour => {
      return `${hour.toString().padStart(2, '0')}:00`; 
    });

    new Chart("myChart2", {
      type: "line",
      data: {
        labels: x2ValuesStr,
        datasets: [{
          label: "Voice Call by Hour",
          fill: false,
          lineTension: 0,
          backgroundColor: "rgba(0,0,255,1.0)",
          borderColor: "rgba(0,0,255,0.1)",
          data: y2Values
        }]
      },
      options: {
        legend: {display: false},
        scales: {
          yAxes: [{ticks: {min: 6, max:16}}],
        }
      }
    });
  });







/*************************this is the form  */
function showCancelWarning() {
  document.getElementById("cancelWarning").classList.remove("d-none");
}

function hideCancelWarning() {
  document.getElementById("cancelWarning").classList.add("d-none");
}

function cancelForm() {
  
  alert("Form canceled");
}



  function toggleSidebar() {
    var sidebar = document.querySelector('.sidebar');
    var sidebarWidth = getComputedStyle(sidebar).width;
    if (sidebarWidth === '0px') {
      sidebar.style.width = '270px';
    } else {
      sidebar.style.width = '0px';
    }
  }
  
  function offcanvas() {
    var menubar = document.getElementById("sidebar");
    menubar.classList.toggle("offcanvas-menu");
    var modal_shadow = document.getElementById("modal-shadow");
    modal_shadow.classList.toggle("show");
    document.body.style.overflow="hidden";
 } 
 function remove() {
    var menubar = document.getElementById("sidebar");
    menubar.classList.toggle("offcanvas-menu");
    var modal_shadow = document.getElementById("modal-shadow");
    modal_shadow.classList.toggle("show");
    document.body.style.overflow="";
 }


    document.querySelector(".filter-box").addEventListener("click", function() {
        var filterSection = document.getElementById("filter-section");
        filterSection.classList.toggle('hidden');
    });


   

