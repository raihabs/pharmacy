x//sidebar to para ipakita kung ano clinick
$(document).ready(function() {
    $('.menu .item').click(function() {
        $('.menu .item').removeClass('active');
        $(this).addClass('active');
        $('.content-container > div').hide();
        var contentToShow = $(this).attr('id').replace('-item', '');
        if (!$(this).hasClass('active') || !$('.content-container > .' + contentToShow).is(':visible')) {
            $('.content-container > .' + contentToShow).show();
        }
    });
});


//reminders to para sa dashboard
function addReminder() {
    var reminderInput = document.getElementById("reminder-input");
    var reminderText = reminderInput.value.trim();
    if (reminderText !== "") {
        var reminderList = document.getElementById("reminder-list");
        var reminderItem = document.createElement("div");
        reminderItem.classList.add("reminder");
        reminderItem.innerHTML = `
            <span>${reminderText}</span>
            <button onclick="deleteReminder(this)" class="delete-reminder-button"><i class="fas fa-trash-alt"></i></button>
        `;
        reminderList.appendChild(reminderItem);
        reminderInput.value = "";
    }
}

function deleteReminder(button) {
    var reminderItem = button.parentElement;
    reminderItem.remove();
}

//para sa viewmore sa dashboard
document.addEventListener("DOMContentLoaded", function() {
    var viewMoreButtons = document.querySelectorAll('.view-more');

    viewMoreButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var targetClass = button.parentElement.classList.contains('total-products') ? 'inventory' : 'sales';
            
            document.querySelector('.dashboard').style.display = 'none';

            document.querySelector('.' + targetClass).style.display = 'block';
        });
    });
});

