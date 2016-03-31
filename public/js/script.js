$(function () {
    $('form').submit(function () {
        $.ajax({
            url: 'index/search', /*nom du controller nom de l'action */
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',

            success: function (data) {
                var film = '';
                var tableBody = $('tbody');
                var filmTable = $('#displayFilms');
                tableBody.html(filmTable);

                for (var i in data.films) {
                    second = data.films[i].duration;
                    minutes = second / 60;
                    second = second % 60;
                    hour = minutes / 60;
                    minutes = minutes % 60;

                    film = tableBody.append(
                        '<tr><td>' + data.films[i].title + '</td><br><br>' +
                        '<td>' + data.films[i].year + '</td><br><br>' +
                        '<td>' + data.films[i].synopsis + '</td><br><br>' +
                        '<td>' + data.films[i].first_name + '</td><br><br>' +
                        '<td>' + data.films[i].last_name + '</td><br><br>' +
                        '<td>' + Math.trunc(hour) + 'h' + Math.trunc(minutes) + '</td><br><br></tr>'
                    );

                }

                if (data.artist != 'undefined') {
                    for (var z in data.artist) {
                        second = data.artist[z].duration;
                        minutes = second / 60;
                        second = second % 60;
                        hour = minutes / 60;
                        minutes = minutes % 60;
                        film = tableBody.append(
                            '<tr><td>' + data.artist[z].title + '</td><br><br>' +
                            '<td>' + data.artist[z].year + '</td><br><br>' +
                            '<td>' + data.artist[z].synopsis + '</td><br><br>' +
                            '<td>' + data.artist[z].first_name + '</td><br><br>' +
                            '<td>' + data.artist[z].last_name + '</td><br><br>' +
                            '<td>' + Math.trunc(hour) + 'h' + Math.trunc(minutes) + '</td><br><br></tr>'
                        );
                    }
                }


                if (data.artistName != 'undefined') {
                    for (var x in data.artistName) {
                        second = data.artistName[x].duration;
                        minutes = second / 60;
                        second = second % 60;
                        hour = minutes / 60;
                        minutes = minutes % 60;

                        film = tableBody.append(
                            '<tr><td>' + data.artistName[x].title + '</td><br><br>' +
                            '<td>' + data.artistName[x].year + '</td><br><br>' +
                            '<td>' + data.artistName[x].synopsis + '</td><br><br>' +
                            '<td>' + data.artistName[x].first_name + '</td><br><br>' +
                            '<td>' + data.artistName[x].last_name + '</td><br><br>' +
                            '<td>' + Math.trunc(hour) + 'h' + Math.trunc(minutes) + '</td><br><br></tr>'
                        );
                    }
                }
            }
            ,

            error: function (data, status, error) {
                var toPrint = '';
                data = JSON.parse(data.responseText);
                for (var d in data.errors) {
                    toPrint += d + ' :' + data.errors[d] + '<br>';
                }
                console.log(toPrint);
            }
        });
        return false;

    });
});