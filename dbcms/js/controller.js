$( document ).ready(function() {
    $('#logout').hide();
    $('#hiddenContent').hide();
    //Event listener for interactions on buttons, links and forms
    function registerEvents(){
        $('button,a,input:submit').unbind('click');
        $('button,a,input:submit').click(function(event) {
            var href = event.target.attributes['href'];
            if(href === undefined || (href !== undefined && href.value.charAt(0) !== '#')){
                var action = null;
                var parameters = [];
                var method = null;
                var controller = null;
                switch(this.localName){
                    case 'button' :
                    case 'a' :
                        if(this.attributes['action'] !== undefined){
                            action = this.attributes['action'].value;
                        }
                        if(this.attributes['controller'] !== undefined){
                            controller = this.attributes['controller'].value;
                        }
                        if(this.attributes['parameter'] !== undefined){
                            parameters.push(this.attributes['parameter'].value);
                        }
                        
                        break;
                    case 'input' :
                        action = this.form.attributes['action'].value;
                        method = this.form.attributes['method'].value;
                        controller = this.form.attributes['controller'].value;
                        for(let element = 0; element < this.form.length; element++)
                        {
                            if(this.form[element].localName === 'button')
                            {
                                continue;
                            }
                            if(this.form[element].name === undefined || this.form[element].value === undefined)
                            {
                                continue;
                            }
                            if(this.form[element].type === 'submit')
                            {
                                continue;
                            }
                            parameters[this.form[element].name] = this.form[element].value;
                        }
                        break;
                    default :
                        break;
                }
                let handle = { 
                    action: action, 
                    parameters: parameters, 
                    method: method, 
                    controller: controller
                };
                if(handle.action !== null && handle.method !== null && handle.controller !== null)
                {
                    event.preventDefault();
                    sendRequest(handle);
                }
                else if(href !== undefined && href.value.charAt(0) === '$')
                {
                    //ref is used to replace content on the page from href attributes on links
                    let ref = href.value.replace('$', '');
                    event.preventDefault();
                    handleReference(ref);
                }else{
                    //console.log('Preventet request: ');
                    //console.log(event);
                }
            }
        });
    }

    function createShopCartListContent(index, name, amount, prize, id){
        
        let number = '<th scope="row">' + index + '</th>';           
        let n = '<td>' + name + '</td>';    
        let a = '<td>' + amount + '</td>';    
        let cost = '<td>' + (amount * prize) + ' $</td>';    
        let button = '<td><form action="RemoveFromCart" method="post" controller="Shop"><input type="hidden" name="ProductID" value="' + id + '"><input type="submit" class="btn btn-outline-danger" value="X"></td></form>';
        let tr = '<tr>' + number + n + a + cost + button + '</tr>'; 
        return tr;   
    }

    function createProductCard(ref, text, title, image, prize){
        let orderButton = '<div class="input-group-append"><input class="btn btn-outline-secondary" type="submit" value="Add to cart"></div>';
        let option0 = '<option selected>Choose Amount</option>';
        let option1 = '<option value="1">1</option>';
        let option2 = '<option value="2">2</option>';
        let option3 = '<option value="3">3</option>';
        let select = '<select name="amount" class="custom-select" id="">' + option0 + option1 + option2 + option3 + '</select>';
        let productID = '<input type="hidden" name="productID" value="' + ref + '">';
        let form = '<form action="AddProductToCart" method="post" controller="Shop">' + select + orderButton + productID +  '</form>';
        let txt = '<p class="card-text">' + text + ' $ ' + prize + '</p>';
        let heading = '<h5 class="card-title">' + title + '</h5>';
        let body = '<div class="card-body">' + heading + txt + form + '</div>';
        let img = '<img class="card-img-top" src="' + image + '" alt="Card image cap">';
        let template = '<div class="card">' + img + body + '</div>';
        return template;
    }

    function loadProducts(ref){
        let params = [];
        params[0] = ref;
        let handle = {
            action: 'ViewList',
            parameters: params,
            method: 'get',
            controller: 'Shop'
        };
        sendRequest(handle);
    }

    function handleReference(ref){
        if(ref === 'sale' || ref === 'merch' || ref === 'ducks'){
            let refContent = $('#contentRef')[0];
            let switchContent = $('#contentSwitch')[0];
            let refHtml = refContent.innerHTML;
            switchContent.innerHTML = refHtml;
            switchContent = $('#contentSwitch').hide();
            loadProducts(ref);
        }else{
            let refContent = $('#contentRef')[0];
            let switchContent = $('#contentSwitch')[0];
            let hiddenContent = $('#hiddenContent')[0];
            let refHtml = switchContent.innerHTML;
            switchContent.innerHTML = "";
            hiddenContent.innerHTML = "";
            refContent.innerHTML = refHtml;
            $('#contentSwitch').hide();
            $('#hiddenContent').hide();
        }
        
    }

    function onSuccess(data, status, request){
        console.log(data);
        if(status === 'success'){
            let responseObject = JSON.parse(data);
            if(responseObject.message === 'siteTitle'){
                let siteTitleElement = $('#siteTitle')[0];
                siteTitleElement.innerText = responseObject.response.PageSettingValue;
            }else if(responseObject.message === 'siteLogo'){
                let siteLogoImageElement = $('#siteLogoImage')[0];
                siteLogoImageElement.src = responseObject.response.PageSettingValue;
            }else if(responseObject.message === 'contact'){
                let contact = $('adress')[0];
                let contactSection = $('#contactSection')[0];
                contact.innerHTML = responseObject.response.ContentValue;
                contactSection.innerHTML = responseObject.response.ContentValue;
            }else if(responseObject.message === 'about'){
                let about = $('#about')[0];
                about.innerHTML = responseObject.response.ContentValue;
            }else if(responseObject.message === 'offer'){
                let offerImage = $('#' + responseObject.response.Offer.OfferName + 'Image')[0];
                let offerValue = $('.' + responseObject.response.Offer.OfferName + 'Value');
                for(let i = 0; i < offerValue.length; i++){
                    offerValue[i].innerText = responseObject.response.Offer.Discount;
                }
                let offerCode = $('#' + responseObject.response.Offer.OfferName + 'Code');
                offerCode[0].innerText = responseObject.response.Offer.OfferName;
                offerImage.src = responseObject.response.Product[0].ProductImage;
            }else if(responseObject.message === 'topseller'){
                let topsellersImage = $('#topsellersImage');
                topsellersImage[0].src = responseObject.response.ProductImage;
                let topsellersName = $('#topsellersName')[0];
                topsellersName.innerText = responseObject.response.ProductName;
                let topsellersPrice = $('#topsellersPrice')[0];
                topsellersPrice.innerText = responseObject.response.Prize;
                let topsellersDescription = $('#topsellersDescription')[0];
                topsellersDescription.innerText = responseObject.response.ProductDescription;
                $('#topsellersProductID')[0].value = responseObject.response.ProductID;
            }else if(responseObject.message === 'highestrated'){
                let topsellersImage = $('#highestratedImage');
                topsellersImage[0].src = responseObject.response.ProductImage;
                let highestratedName = $('#highestratedName')[0];
                highestratedName.innerText = responseObject.response.ProductName;
                let highestratedPrice = $('#highestratedPrice')[0];
                highestratedPrice.innerText = responseObject.response.Prize;
                let highestratedDescription = $('#highestratedDescription')[0];
                highestratedDescription.innerText = responseObject.response.ProductDescription;
                $('#highestratedProductID')[0].value = responseObject.response.ProductID;
            }else if(responseObject.message === 'newinstock'){
                let topsellersImage = $('#newinstockImage');
                topsellersImage[0].src = responseObject.response.ProductImage;
                let newinstockName = $('#newinstockName')[0];
                newinstockName.innerText = responseObject.response.ProductName;
                let newinstockPrice = $('#newinstockPrice')[0];
                newinstockPrice.innerText = responseObject.response.Prize;
                let newinstockdescription = $('#newinstockDescription')[0];
                newinstockdescription.innerText = responseObject.response.ProductDescription;
                $('#newinstockProductID')[0].value = responseObject.response.ProductID;
            }else if(responseObject.message === 'login'){
                if(responseObject.response != null){
                    hideLoginSignup();
                }
            }else if(responseObject.message === 'signup'){
                hideLoginSignup();
            }else if(responseObject.message === 'logout'){
                $('#signUpTrigger').show();
                $('#logInTrigger').show();
                $('#logout').hide();
            }else if(responseObject.message === 'search'){
                //Not implemented in front end
            }else if(responseObject.message === 'list'){
                displayProductsHtml(responseObject.response);
            }else if(responseObject.message === 'order'){
                updateCartRequest();
            }else if(responseObject.message === 'shopCartUpdate'){
                hideLoginSignup();
                updateCartContent(responseObject.response.order, responseObject.response.products);
            }else if(responseObject.message === 'removeFromCart'){
                updateCartContent(responseObject.response.order, responseObject.response.products);
                updateCartRequest();
            }
            registerEvents();
        }
    }

    function updateCartContent(order, products){
        if(order !== null){
            $('#cartCounter')[0].innerText = products.length;
            let totalCostCounter = $('#cartTotalCost')[0];
            totalCostCounter.innerText = 'Total Cost: $' + order.TotalCost;
            let productsHtml = "";
            for(let i = 0; i < products.length; i++){
                productsHtml = productsHtml + createShopCartListContent(i, products[i][0].ProductName, 1, products[i][0].Prize, products[i][0].ProductID);
            }
            $('#shopCartListContent')[0].innerHTML = productsHtml;
        }
    }

    function updateCartRequest(){
        let handle = { 
            action: 'ViewOrder', 
            parameters: [], 
            method: 'get', 
            controller: 'Shop'
        };
        sendRequest(handle);
    }

    function displayProductsHtml(productsArray)
    {
        let result = "<div class='container-fluid d-flex justify-content-center'><div class='row'>";
        productsArray.forEach(element => {
            result = result + "<div class='col-sm-12 col-md-4 col-lg-3'>" + 
            createProductCard(
                element.ProductID, 
                element.ProductDescription, 
                element.ProductName, 
                element.ProductImage, 
                element.Prize) + "</div>";
        });
        $('#contentRef')[0].innerHTML = "" + result + "</div></div>";
    }

    function hideLoginSignup(){
        $('#signUpTrigger').hide();
        $('#logInTrigger').hide();
        $('#logout').show();
    }

    function onError(request, status, error){
        console.log({
            status: status,
            error: error,
            request: request
        });
    }

    function sendRequest(handle){
        if(handle.method === 'get'){
            $.ajax({
                url: "app/app.php",
                type: handle.method,
                data: {
                    controller: handle.controller,
                    action: handle.action,
                    parameter: handle.parameters[0]
                },
                contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
                success: onSuccess,
                error: onError
             });
        }else{
            handle.parameters['controller'] = handle.controller;
            handle.parameters['action'] = handle.action;
            $.ajax({
                url: "app/app.php",
                type: handle.method,
                data: Object.assign({}, handle.parameters),
                success: onSuccess,
                error: onError
             });
        }
    }

    function getSiteTitle(){
        let handle = { 
            action: 'ReadSiteTitle', 
            parameters: [], 
            method: 'get', 
            controller: 'Shop'
        };
        sendRequest(handle);
    }
    function getSiteLogoImage(){
        let handle = {
            action: 'ReadSiteLogo',
            parameters: [],
            method: 'get',
            controller: 'Shop'
        };
        sendRequest(handle);
    }
    function getContact(){
        let handle = {
            action: 'ReadContact',
            parameters: [],
            method: 'get',
            controller: 'Shop'
        };
        sendRequest(handle);
    }
    function getAbout(){
        let handle = {
            action: 'ReadAbout',
            parameters: [],
            method: 'get',
            controller: 'Shop'
        };
        sendRequest(handle);
    }
    function getOffer(offerName){
        let params = [];
        params[0] = offerName;
        let handle = {
            action: 'ReadOffer',
            parameters: params,
            method: 'get',
            controller: 'Shop'
        };
        sendRequest(handle);
    }
    function getFeaturedProduct(category){
        let params = [];
        params[0] = category;
        let handle = {
            action: 'ReadFeaturedProduct',
            parameters: params,
            method: 'get',
            controller: 'Shop'
        };
        sendRequest(handle);
    }
    getSiteTitle();
    getSiteLogoImage();
    getContact();
    getAbout();
    getOffer('Discount');
    getOffer('Wholesale');
    getOffer('Seasonal');
    getFeaturedProduct('topseller');
    getFeaturedProduct('highestrated');
    getFeaturedProduct('newinstock');
    updateCartRequest();
});