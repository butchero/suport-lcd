// when the page loads, transform all product images into draggable items
// and allow them to be dropped on the cart
window.onload = function() {
	// retrieve all product images
	var draggables = $$("div.productImg");
	// make them all draggable
	draggables.each(function(currentDraggable) { 
		new Draggable(currentDraggable, { revert: true, ghosting: true });												 
	});
	
	// define the cart as a droppable
	Droppables.add("cart", {
		hoverclass: "cartOnHover",
		onDrop: function(element) {
			// each product image has an id like 'product_x', where 'x' is the database id,
			// so we extract it next
			var itemId = element.id.split("_");
			addToCart(itemId[1], "msg_"+itemId[1]);
		}
	});
	
	// bind a progress indicator to all Ajax calls
	startAjax();
}

function startAjax()
{
	Ajax.Responders.register({
	  // when an Ajax request is started, show the indicator
		onCreate: function() {
		if (Ajax.activeRequestCount > 0)
		  Element.show($("indicator"));
	  },
		// when an Ajax request is finished, hide the indicator
		onComplete: function() {
		if (Ajax.activeRequestCount == 0)
		  Element.hide($("indicator"));
	  }
	});
}

// add item to cart
function addToCart(id, msg_id)
{
	new Ajax.Request("/server.php?action=addToCart&"+Math.random(9999), {
		parameters: "id=" + id,
		onSuccess: function(resp) {
			var cartUpdate = eval('(' + resp.responseText + ')');
			var isNew = cartUpdate['cartItemDetails'][0].isNew;
			// if this item is new in the cart, inject it inside, otherwise update the qty and subtotal
			if (isNew == 1)
			{
				$(msg_id).show();
				Effect.Fade(msg_id);
				var newItem = '<div id="cartItem_' + id + '" style="display:none" class="row">';
				newItem += '<div class="cell1" id="cartItemQty_' + id + '" valign="top">1</div>';
				newItem += '<div class="cell2">' + cartUpdate['cartItemDetails'][0].title + '</div>';
				newItem += '<div class="cell3" id="cartItemPrice_' + id + '">' + cartUpdate['cartItemDetails'][0].newPrice + ' RON</div>';
				newItem += '<div class="cell4"><a href="/server.php?action=removeFromCart&id=' + id + '" onclick="return removeFromCart(' + id + ')">';
				newItem += 'X</a></div><div class="clear"></div></div>';
				
				if ($("cartIsEmpty"))
					Element.hide($("cartIsEmpty"));

				new Insertion.Bottom("cartItems", newItem);	
				
				Effect.Appear("cartItem_" + id, { duration: 0.5 });
				Element.update($("cartTotalAmount"), "<b>Total: " + cartUpdate['cartItemDetails'][0].total + " RON</b>");
				new Effect.Highlight("cartTotalAmount", {startcolor:'#CCCCCC', endcolor:'#F7F7F7', restorecolor:'#F7F7F7'});
			}
			// so, the item already existed in the cart, therefore update its quantity and subtotal
			else
			{
				$(msg_id).show();
				Effect.Fade(msg_id);
				Element.update($("cartItemQty_" + id), cartUpdate['cartItemDetails'][0].newQty);
				Element.update($("cartItemPrice_" + id), cartUpdate['cartItemDetails'][0].newPrice + " RON");
				Element.update($("cartTotalAmount"), "Total: " + cartUpdate['cartItemDetails'][0].total + " RON");
				new Effect.Highlight("cartTotalAmount", {startcolor:'#CCCCCC', endcolor:'#F7F7F7', restorecolor:'#F7F7F7'});
				new Effect.Highlight("cartItemPrice_" + id, {startcolor:'#CCCCCC', endcolor:'#F7F7F7', restorecolor:'#F7F7F7'});
				new Effect.Highlight("cartItemQty_" + id, {startcolor:'#CCCCCC', endcolor:'#F7F7F7', restorecolor:'#F7F7F7'});
			}
		}
	});
	return false;
}

// remove an item from the cart
function removeFromCart(id)
{
	Effect.Fade("cartItem_" + id);
	new Ajax.Request("/server.php?action=removeFromCart&"+Math.random(9999), {
		parameters: "id=" + id,
		onSuccess: function(resp) {
			var total = resp.responseText;
			if (total == 0)
			{
				// update the cart's total amount and contents
				Element.update($("cartItems"), '<div id="cartIsEmpty">Cosul este gol.</div>');
				Element.update($("cartTotalAmount"), "<b>Total: 0.00 RON</b>");
				new Effect.Highlight("cartIsEmpty", {startcolor:'#CCCCCC', endcolor:'#F7F7F7', restorecolor:'#F7F7F7'});
			}
			else
			{
				// update the cart's total amount
				Element.update($("cartTotalAmount"), "<b>Total: " + total + " RON</b>");
			}
			new Effect.Highlight("cartTotalAmount", {startcolor:'#CCCCCC', endcolor:'#F7F7F7', restorecolor:'#F7F7F7'});
		}
	});
	return false;
}

// empty the cart
function emptyCart()
{
	new Ajax.Request("/server.php?action=emptyCart&"+Math.random(9999), {
		onSuccess: function(resp) {
			if (resp.responseText == 1)
			{
				// update the cart's total amount and contents
				Element.update($("cartItems"), '<div id="cartIsEmpty">Cosul este gol.</div>');
				Element.update($("cartTotalAmount"), "<b>Total: 0.00 RON</b>");
				new Effect.Highlight("cartIsEmpty", {startcolor:'#CCCCCC', endcolor:'#F7F7F7', restorecolor:'#F7F7F7'});
				new Effect.Highlight("cartTotalAmount", {startcolor:'#CCCCCC', endcolor:'#F7F7F7', restorecolor:'#F7F7F7'});
			}
		}
	});
	return false;
}