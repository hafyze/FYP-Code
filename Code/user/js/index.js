let = urlParams = newURLSearchParams(window.location.search);
if(urlParams.get('success') === '1') {
    alert("Update Successful");
}