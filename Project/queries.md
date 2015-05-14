###Exercises 5.4.1 - XPath

1. All title elements
	
	movies: `/movies//title` <br>
	movies_ref: `/movies//title`

2. All movie titles (i.e., the textual value of title elements).
	
	movies: `/movies//title/node()` <br>
	movies_ref: `/movies//title/node()`
	
3. Titles of the movies published after 2000.

	movies: `/movies/movie[year>2000]/title/node()` <br>
	movies_ref: `/movies/movie[year>2000]/title/node()`

4. Summary of “Spider-Man”.

	movies: `/movies/movie[title="Spider-Man"]/summary/node()` <br>
	movies_ref: `/movies/movie[title="Spider-Man"]/summary/node()`

5. Who is the director of Heat?

	movies: `string-join((/movies/movie[title="Heat"]/director/first_name/node(),/movies/movie[title="Heat"]/director/last_name/node()),' ')` <br>
	movies_ref: `string-join((/movies/artist[@id = /movies/movie[title="Heat"]/director/@id]/first_name/node(),
/movies/artist[@id = /movies/movie[title="Heat"]/director/@id]/last_name/node()),' ')`

6. Title of the movies featuring Kirsten Dunst.

	movies: `/movies/movie/actor[first_name="Kirsten", last_name="Dunst"]/../title/node()`<br>
	movies_ref: `/movies/movie/actor[@id = //artist[first_name="Kirsten", last_name="Dunst"]/@id]/../title/node()`
	
7. Which movies have a summary?

	movies: `/movies//movie[exists(summary)]/title/node()`<br>
	movies_ref: `/movies//movie[exists(summary)]/title/node()`
	
8. Which movies do not have a summary?

	movies: `/movies//movie[not(exists(summary))]/title/node()`<br>
	movies_ref: `/movies//movie[not(exists(summary))]/title/node()`
	
9. Titles of the movies published more than 5 years ago.

	movies: `/movies//movie[year<2010]/title/node()`<br>
	movies_ref: `/movies//movie[year<2010]/title/node()`
	
10. What was the role of Clint Eastwood in Unforgiven?

	movies: `/movies/movie[title="Unforgiven"]/actor[fist_name="Clint", last_name="Eastwood"]/role/node()`<br>
	movies_ref: `string(/movies/movie[title="Unforgiven"]/actor[@id = /movies/artist[fist_name="Clint", last_name="Eastwood"]/@id]/@role)`
	
11. What is the last movie of the document?

	movies: `/movies/movie[last()]/title/node()`<br>
	movies_ref: `/movies/movie[last()]/title/node()`
	
12. Title of the film that immediately precedes Marie Antoinette in the document?

	movies: `/movies/movie[title="Marie Antoinette"]/preceding::movie[1]/title/node()`<br>
	movies_ref: `/movies/movie[title="Marie Antoinette"]/preceding::movie[1]/title/node()`
	
13. Get the movies whose title contains a “V”.

	movies: `/movies/movie[contains(title, 'V')]/title/node()` <br>
	movies_ref: `/movies/movie[contains(title, 'V')]/title/node()`
	
14. Get the movies whose cast consists of exactly three actors.

	movies: `/movies/movie[count(actor) = 3]/title/node()`<br>
	movies_ref: `/movies/movie[count(actor) = 3]/title/node()`
	
###Exercises 5.4.2 - Xquery

1. List the movies published after 2002, including their title and year.
    ```
let $ms := doc("movies/movies_alone.xml"),
    $as := doc("movies/artists_alone.xml")

for $movie in $ms/movies/movie[year > 2002]
    return <movie> { ($movie/title, $movie/year) } </movie>
   ```

2. Create a flat list of all the title-role pairs, with each pair enclosed in a “result” element. Here is an example of the expected result structure:

  ```
let $ms := doc("movies/movies_alone.xml"),
    $as := doc("movies/artists_alone.xml")

return
    <results>
    { for $actor in $ms//actor
        return 
            <result>
                {$actor/../title}
                <role>{data($actor/attribute::role)}</role>
            </result>
    }
    </results>
  ```

3. Give the title of movies where the director is also one of the actors.

  ```
	let $ms := doc("movies/movies_alone.xml"),
	$as := doc("movies/artists_alone.xml")
	
	for $movie in $ms//movie
	    let $director_id := data($movie/director/attribute::id)
	    for $actor in $movie/actor
	        let $actor_id := data($actor/attribute::id)            
	        return
	            if ($director_id = $actor_id)
	            then $movie/title/node()
	            else ()
  ```
4. Show the movies, grouped by genre.
  ```
  let $ms := doc("movies/movies_alone.xml"),
    $as := doc("movies/artists_alone.xml")
    
for $genre in distinct-values($ms//genre)
    let $movies := $ms//movie[genre = $genre]
    return 
        <genre>
        {$genre}{
            for $movie in $movies
                return $movie/title
        }
        </genre>
  ```

5. For each distinct actor’s id in movies_alone.xml, show the titles of the movies where this actor
plays a role. The format of the result should be:
  ```
	let $ms := doc("movies/movies_alone.xml"),
	$as := doc("movies/artists_alone.xml")
	
	for $actor_id in distinct-values(data($ms//actor/attribute::id))
	    let $movies := $ms//movie[actor/attribute::id = $actor_id]
	    return 
	        <actor>
	            {$actor_id},{
	                for $movie in $movies
	                   return $movie/title
	            }
	        </actor>
  ```
Variant: show only the actors which play a role in at least two movies (hint: function count()
returns the number of nodes in a sequence).
  ```
   	let $ms := doc("movies/movies_alone.xml"),
	$as := doc("movies/artists_alone.xml")
	
	for $actor_id in distinct-values(data($ms//actor/attribute::id))
	    let $movies := $ms//movie[actor/attribute::id = $actor_id]
	    return 
	        if (count($movies) > 1)
	        then
	            <actor>
	                {$actor_id},{
	                    for $movie in $movies
	                        return $movie/title
	                }
	            </actor>
	        else()
  ```
6. Give the title of each movie, along with the name of its director.
  
  ```
  let $ms := doc("movies/movies_alone.xml"),
    $as := doc("movies/artists_alone.xml")
    
for $movie in $ms//movie
    let $director_id := data($movie/director/attribute::id)
    let $director := $as//artist[attribute::id = $director_id]
    return
        <movie> {
        $movie/title,
        if (exists($director))
        then <director>{string-join(($director/first_name/node(), $director/last_name/node()), " ")}</director>
        else ()
        } </movie>
  ```
  
7.  Give the title of each movie, and a nested element <actors> giving the list of actors with their
role.


8. For each movie that has at least two actors, list the title and first two actors, and an empty "et-al" element if the movie has additional actors. For instance:

   ```
<result>
<title>Unforgiven</title>
<actor>Clint Eastwood as William ’Bill’ Munny</actor>
<actor>Gene Hackman as Little Bill Daggett</actor>
<et-al/>
</result>
  ```

9. List the titles and years of all movies directed by Clint Eastwood after 1990, in alphabetic order.
