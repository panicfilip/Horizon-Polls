(function() {
    $('div.alert').delay(3000).slideUp(300);
})();

(function() {
    var createField = function(name, count) {
        var nameLowerCount = name.toLowerCase() +'_'+ count;

        var label = $('<label>')
                    .prop('for', nameLowerCount).text(name + " " + count);

        var input = $('<input>')
                    .prop({'type': 'text', 'name': "choices[]", 'id': nameLowerCount, 'class': 'form-control'});

        var unit = $('<div>')
                    .prop({'id': nameLowerCount, 'class': 'form-group'})
                    .append(label)
                    .append(input);

        return unit;
    };

    var count = $(".choice").length;

    $('button#add-choice').on('click', function() {
        count++;
        var choiceField = createField("Choice", count);
        $('div.choices').append(choiceField);
        $('button#add-choice').appendTo('div.choices');
        $('button#remove-choice').appendTo('div.choices');
        console.log(count);
    });

    $('button#remove-choice').on('click', function() {
        if(count>2){
            $('#choice_'+count).remove();
            count--;
            $('button#add-choice').appendTo('div.choices ');
            $('button#remove-choice').appendTo('div.choices ');
            console.log(count);
        }else{
            alert('2 Choices are minimum!')
        }
    });

})();

//# sourceMappingURL=scripts.js.map
