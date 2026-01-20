document.addEventListener('DOMContentLoaded', function () {
    const bk_form = document.getElementById('bk_form_id');
    const bk_form_status = document.getElementById('bk_form_status');


    bk_form.addEventListener("submit", async function (e) {
        e.preventDefault();
        const formData = new FormData(this)
        formData.append('action', 'bk_form_aj')
        // formData.append(this)
        // ;
        const ajax_url = bk_js.ajax_url;
        // console.log(formData.values);

        let response = await fetch(ajax_url, {
            method: 'post',
            body: formData,
        });

        let res = await response.json();

        if (res.success) {
            bk_form.reset();
            bk_form_status.setAttribute('class', "border p-5 mt-5 ease-out");
            bk_form_status.innerHTML = "Sent Successfully";
            setTimeout(() => {
                bk_form_status.setAttribute('class', 'invisible')
            }, 3000);

        } else {
            bk_form_status.setAttribute('class', "border p-5 mt-5 ease-out");
            bk_form_status.innerHTML = "All field required";
            setTimeout(() => {
                bk_form_status.setAttribute('class', 'invisible')
            }, 2000);
        }

    })

});