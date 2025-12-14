<?php
$dates = service('dates');
$numbers = service('numbers');
$date = $dates->get_Date();
//$msint = model("App\Modules\Sint\Models\Sint_Mongo");
//$count = number_format($msint->count(), 0, ',', '.');
//$url = 'https://mongo.c4isr.co/api/sint/json/count/123';
?>
<div class="col-12 mb-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                    <div class="card-title">
                        <h5 class="text-nowrap p-0 m-0">Brechas detectadas</h5>
                        <span class="badge bg-label-warning rounded-pill p-0 m-0"><?php echo($date); ?></span>
                    </div>
                    <div class="mt-sm-auto">
                        <small class="text-success text-nowrap fw-medium"
                        ><i class="bx bx-chevron-up"></i>68.7%</small
                        >
                        <h3 id="count-breaches" class="mb-0"><img src="/themes/assets/images/gifs/loader1.gif"
                                                                  alt="loading" height="24px"/></h3>
                    </div>
                </div>
                <div id="profileReportChart"></div>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateBreachesCount() {
            fetch('https://mongo.c4isr.co/api/sint/json/count/123')
                .then(response => response.json())
                .then(data => {
                    // Convert the text string into a JSON object
                    const jsonObject = JSON.parse(data);
                    // Access the properties of the JSON object
                    console.log("Status:", jsonObject.status);
                    console.log("Message:", jsonObject.message);
                    console.log("Count:", jsonObject.data.count);
                    // Update the "count-breaches" element with the count value
                    document.getElementById('count-breaches').textContent = jsonObject.data.count;
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }

        updateBreachesCount();
        setInterval(updateBreachesCount, 2000);
    });
</script>