###Exercises 5.4.1 - XPath

1. All title elements
	
	`/movies//title`

2. All movie titles (i.e., the textual value of title elements).
	
	`/movies//title/node()`
	
3. Titles of the movies published after 2000.

	`/movies/movie[year>2000]/title/node()`

4. Summary of “Spider-Man”.

5. Who is the director of Heat?

6. Title of the movies featuring Kirsten Dunst.

7. Which movies have a summary?

8. Which movies do not have a summary?
9. Titles of the movies published more than 5 years ago.
10. What was the role of Clint Eastwood in Unforgiven?
11. What is the last movie of the document?
12. Title of the film that immediately precedes Marie Antoinette in the document?
13. Get the movies whose title contains a “V”.
14. Get the movies whose cast consists of exactly three actors.

###Exercises 5.4.2 - Xquery

1. List the movies published after 2002, including their title and year.2. Create a flat list of all the title-role pairs, with each pair enclosed in a “result” element. Here is an example of the expected result structure:

```<results>  <result><title>Heat</title>  <role>Lt. Vincent Hanna</role></result><result>  <title>Heat</title>  <role>Neil McCauley</role></result></results>
```

3. Give the title of movies where the director is also one of the actors.4. Show the movies, grouped by genre. Hint: function distinct-values() removes the duplicatesfrom a sequence. It returns atomic values.5. For each distinct actor’s id in movies_alone.xml, show the titles of the movies where this actorplays a role. The format of the result should be:

```
<actor>16,<title>Match Point</title><title>Lost in Translation</title></actor>
```
6. Give the title of each movie, along with the name of its director. Note: this is a join!
7.  Give the title of each movie, and a nested element <actors> giving the list of actors with theirrole.
8. For each movie that has at least two actors, list the title and first two actors, and an empty "et-al" element if the movie has additional actors. For instance:
```<result><title>Unforgiven</title><actor>Clint Eastwood as William ’Bill’ Munny</actor><actor>Gene Hackman as Little Bill Daggett</actor><et-al/></result>
```
9. List the titles and years of all movies directed by Clint Eastwood after 1990, in alphabetic order.
