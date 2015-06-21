##Web Data Management Assignment 3 Writeup
Alex Simes (4415299)  and Peter van Buul (1512269)

####Introduction
For this assignment, we built two solutions to the problem of finding triangles inside graphs, one with Hadoop and one with Apache Giraph. For the first sollution we used Apache Giraph (which uses Hadoop) to count triangles. Next, we used regular Hadoop map-reduce to solve the problem. Both the solutions are written in Java and are jarred up in a single jar file. This file is used to call eiher solution. 

In addition to these two solutions, we also built a script that automates the running of both solutions on a given graph. The script also runs a brute-force php solution we implemented to check the output. 

####Apache Giraph

##### Brief Explanation

The Apache Giraph solution works in four steps during which messages are send along the edges of the triangle. In the first step a message containing the ID of the sending node is send along all edges of which the neigboring vertex has a higher ID. If this vertex is part of a triangle then it is sending a message along the AB edge of the ABC tirangle. In the second step this message is forwarded to again to all edges of which the neigboring vertex has an higher ID. If this vertex is part of the ABC triangle it now forwards this message along the BC edge. In the thirth step the message is forwarded to all neighbors, if this vertex is part of the ABC triangle it now forwards this message along the BC edge. In the last step the ID's of the messages are compared with the ID of the current vertex. If the message ID matches the ID of the vertex the message in this message has traveled along three edges in a triangle, thus a triangle is counted.

##### Pseudo Code

```
//step1
foreach neighbor {
  if (neighborId > ownId) {
    send selfId to neighbor
  }
}

//step 2
foreach message {
  foreach neighbor {
    if (neighborId > ownId) {
      send message to neighbor
    }
  }
}

//step 3
foreach message {
  foreach neighbor {
    send message to neighbor
  }
}

//step 4
numberOfTriangles = 0
foreach message {
  if (messagePayload == ownId) {
    numberOfTriangles++
  }
}

ownValue = numberOfTriangles
```

####Hadoop Map-Reduce	


####Testing Script


