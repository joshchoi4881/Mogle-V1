$("#pieChartsButton").on("click", () => {
  const start_date = $("#startDate").val();
  const end_date = $("#endDate").val();
  $.ajax({
    url: "/mogle/AJAX/HTTP/get_transactions.php",
    method: "POST",
    data: {
      public_token: PUBLIC_TOKEN,
      start_date: start_date,
      end_date: end_date,
    },
    timeout: 0,
    success: (data) => {
      let data1 = JSON.parse(data);
      console.log(data1);
      console.log(data1.transactions);
      if (typeof data1.transactions != "undefined") {
        $.ajax({
          url: "/mogle/AJAX/HTTP/get_expenses_income.php",
          method: "POST",
          data: {
            transactions: data1.transactions,
          },
          timeout: 0,
          success: (data) => {
            let data2 = JSON.parse(data);
            console.log(data2);
            console.log(data2.categoriesExpenses);
            console.log(data2.categoriesIncome);
            if (typeof data2.categoriesExpenses != "undefined") {
              // Show element
              $("#expensesPieChart").css("display", "block");
              // Expenses data
              var chartDataExpenses = [];
              for (const [key, value] of Object.entries(
                data2.categoriesExpenses
              )) {
                chartDataExpenses.push({ x: key, value: value });
              }
              // Create a chart and set the data
              chart = anychart.pie(chartDataExpenses);
              // Set the container id
              chart.container("container1");
              // Initiate drawing the chart
              chart.draw();
            }
            if (typeof data2.categoriesIncome != "undefined") {
              // Show element
              $("#incomePieChart").css("display", "block");
              // Income data
              var chartDataIncome = [];
              for (const [key, value] of Object.entries(
                data2.categoriesIncome
              )) {
                chartDataIncome.push({ x: key, value: value });
              }
              // Create a chart and set the data
              chart = anychart.pie(chartDataIncome);
              // Set the container id
              chart.container("container2");
              // Initiate drawing the chart
              chart.draw();
            }
          },
          error: (xhr, status, error) => {
            console.log(xhr.responseText);
          },
        });
      } else {
        console.log("Could not get transactions");
      }
    },
    error: (xhr, status, error) => {
      console.log(xhr.responseText);
    },
  });
});  