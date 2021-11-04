# Full Face Landmarks Detection (Highly Improved)
> “What this algorithm does to the landmarks, is the same thing that a dentist/orthodontist does to his patient's teeth”

<br>
<video loop autoplay muted height="480" src="https://download1589.mediafire.com/e06n9v58jnhg/gnl6u12mllwrp40/hair.mp4
"></video><br>
<br>
<h3>What's improved?</h3>

<ol>
    <li>
        <b>Better Quality - Method 1:</b><br>
by using the best of the shape_predictor_68_landmarks (higher quality BUT fewer landmarks) and shape_predictor_81_landmarks (more landmarks -full face- BUT lower quality) we got a high quality full face landmarks detection.<br>
    </li>
    <li>
        <b>Better Quality - Method 2:</b><br>
the accuracy of shape_predictor_81_landmarks is <b>improved by repositioning forehead landmarks coordinates to a more accurate position.</b><br>
    </li>
</ol>



<h3>How is it improved</h3>
<ol>
    <li>
        <b>Method 1</b>:<br>
using both 68 and 81 landmarks predictors is done by partial selection, select the 68 points from the 68 landmarks shape predictor and the last 13 points from the 81 landmarks shape predictor<br>
    </li>
    <li>
        <b>Method 2</b>:<br>
moving the forehead landmarks is improved by heuristically clustering skin colors and giving a range for each cluster, then moving every point individually upward by a specified step size (a number in pixels), until the color underneath the landmarks is out of the skin color range -which means we reached the edge between forehead & hair-, there, is the best position for a landmark on the forehead<br>
    </li>
    <li>
        <b>How to determine the range of the skin color?</b>: <br>
take a slice from the nose (the most part that's not affected by shadows/lights issues), then calculate the average of pixels colors, then discover which cluster is this skin color, finally set range based on that cluster. <br>
    </li>
    <li>
        <h3>What if the forehead is too clear (bald man)?:</h3>
       <video loop autoplay muted height="480" src="https://download1494.mediafire.com/uxnyyyfn035g/s23azhnqfu6ci35/bald.mp4
    "></video><br>
    </li>
    <li>
        <h3>What if the forehead isn't clear, (hair covers it)?:</h3>
   <video loop="true" muted autoplay height="480" src="https://download1488.mediafire.com/h3rqg2fr2lkg/ygkrqsjpot665c3/haircut.mp4"></video>
    </li>
</ol>

