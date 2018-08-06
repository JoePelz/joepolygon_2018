  <div id="SectionContainer">
    <h1>Programming Languages</h1>
    <p>Parlez-vous Deutsch amigo?</p>
  </div>
  <div class="content">
    <div class="center"><img src="/assets/articles/linguistics/link.jpg"></div>
    <p>During spring break of 2015 at BCIT, I went and redid one of my assignments a few times in a few different languages:  C++, Haskell, JavaScript, PowerShell, and Python.  C++ was the course I was studying and I had done a fair bit of python before.  JavaScript I’d touched a couple times, but Haskell and PowerShell were completely unfamiliar to me.</p>
    <p>The assignment I chose was a small lab assignment to calculate which set of 7 numbers had the most permutations that were prime numbers.</p>
    <p>Considering 3-digit numbers, as a simpler example, gives a maximum of 4 permutations.  There are 3 different solutions tied with 4 permutations.</p>
    <div class="widthLimit"><ul>
      <li>149, 419, 491, 941 </li>
      <li>179, 197, 719, 971 </li>
      <li>379, 397, 739, 937 </li>
    </ul></div>
    <p>3-digit numbers are easy to work with, but when you get up to 7-digit numbers it becomes more important how you choose to solve it.  I really enjoyed solving this one.  So much so that I resolved it in a few different languages.  The code is the purpose of this article so I’m about to give away how to solve it.  Stop now if you want to do it yourself.</p>
    <h2>Solutions</h2>
    <p>The general solution I used is</p>
    <div class="widthLimit"><ol>
      <li>Generate all the prime numbers in the range you need: e.g. [1000000:9999999] </li>
      <li>Write a function that will take a number in that same range, and turn it into a key based on the digits it contains, so that 1045, 1405, 5041, and 4501 all give the same key </li>
      <li>Group all the prime numbers that have the same key, or just keep the largest group if you don’t care about ties. </li>
      <li>Report the largest group(s). </li>
    </ol></div>
    <p>One other note: Do not take the results below as a benchmark for a language speed comparison.  I ran different code in each of the languages, some of which I had no knowledge of prior to starting this project and are not necessarily optimal. Haskell was run through a virtual machine, C++ through Cygwin, JavaScript through chromium.</p>
    <h2 onclick="toggleCollapse('c++');">C++</h2>
    <div class="collapsing collapsed" onclick="toggleCollapse('c++');" id="c++">
      <p>In C++ the code was quite straightforward.  I had been writing in C++ recently and was able to translate the algorithm into code in less than an hour.</p>
      <p>I was able to take advantage of the bitset type to both shrink my volume of data and probably make it faster to manipulate.  Since strings are mutable in C++, most people in my class converted the number to a string and then ran quicksort on it.  I felt like doing something different so I wrote a function that would generate a key using only numeric transformations.  My solution would work up to 9-digit numbers, although it could be generalized for more.</p>
      <div class="widthLimit"><ol class="code heightLimit">
        <li>#include &lt;iostream&gt; </li>
        <li>#include &lt;algorithm&gt; </li>
        <li>#include &lt;bitset&gt; </li>
        <li>#include &lt;vector&gt; </li>
        <li>#include &lt;map&gt; </li>
        <li> </li>
        <li>using namespace std; </li>
        <li> </li>
        <li>#define SIZE 7 </li>
        <li>#define LOW 1000000 </li>
        <li>#define N 9999999 </li>
        <li> </li>
        <li>//isprime[n] is 1 if n is prime, 0 if n is not prime </li>
        <li>bitset&lt;N&gt; isprime; </li>
        <li> </li>
        <li>int reorder(int n); </li>
        <li>void loadPrimes(); </li>
        <li> </li>
        <li>int main() { </li>
        <li>    map&lt;int, vector&lt;int&gt;&gt; results; </li>
        <li> </li>
        <li>    //generate primes </li>
        <li>    loadPrimes(); </li>
        <li> </li>
        <li>    //for all numbers LOW to HIGH </li>
        <li>    for (size_t i=LOW; i&lt;N; i++) </li>
        <li>        if (isprime[i]) </li>
        <li>            results[reorder(i)].push_back(i); </li>
        <li> </li>
        <li>    //find the max prime combinations </li>
        <li>    pair&lt;int, vector&lt;int&gt;&gt; max{0, {}}; </li>
        <li>    for (auto& x : results) { </li>
        <li>        if (x.second.size() &gt; max.second.size()) </li>
        <li>            max = x; </li>
        <li>    } </li>
        <li> </li>
        <li>    cout &lt;&lt; "Highest: " &lt;&lt; endl </li>
        <li>         &lt;&lt; max.first &lt;&lt; ": " &lt;&lt; max.second.size() &lt;&lt; endl; </li>
        <li>} </li>
        <li> </li>
        <li>//generate all prime numbers in range </li>
        <li>void loadPrimes() { </li>
        <li>    isprime.set(); </li>
        <li>    for (size_t i=2; i &lt; N; i++) </li>
        <li>        if (isprime[i]) </li>
        <li>            for(size_t j = 2; j * i &lt; N; j++) </li>
        <li>                isprime[j*i]=0; </li>
        <li>} </li>
        <li> </li>
        <li>//generate a key for the given number </li>
        <li>int reorder(int n) { </li>
        <li>    int result = 0; </li>
        <li>    static int v[SIZE]; </li>
        <li>    for(int i = 0; i &lt; SIZE; ++i) { </li>
        <li>        v[i] = n % 10; </li>
        <li>        n /= 10; </li>
        <li>    } </li>
        <li>    sort(v, v + SIZE); </li>
        <li>    for (auto x : v) { </li>
        <li>        result *= 10; </li>
        <li>        result += x; </li>
        <li>    } </li>
        <li>    while (result &lt; LOW) </li>
        <li>        result *= 10; </li>
        <li>    return result; </li>
        <li>} </li>
      </ol></div>
      <p>Running the code in c++ took about 2 seconds on my laptop for a 7-digit number. No other language that followed came close to meeting that speed.</p>
    </div>
    <h2 onclick="toggleCollapse('haskell');">Haskell</h2>
    <div class="collapsing collapsed" onclick="toggleCollapse('haskell');" id="haskell">
      <p>Haskell was an interesting language to investigate.  This was my first time installing it and coding in it.  It’s a functional language, so it feels like all I’m doing is setting up the relationships between variables, and then, only at the very end, I’m requesting a value to print.  Once that value is requested, Haskell works backwards to resolve all the dependencies and calculate the necessary intermediate values to give me what I wanted to print out.</p>
      <p>Another thing that I found really interesting was that all the functions were pure.  There were no global variables in the background being manipulated, nor any object state.  It was pure functions with no side effects.  It practically eliminates runtime errors, and it feels good too.</p>
      <div class="widthLimit"><ol class="code heightLimit">
        <li>module lab6Haskell </li>
        <li>	where </li>
        <li> </li>
        <li>upperBound = 99999 </li>
        <li>lowerBound = 10000 </li>
        <li>myPrimes = filter (&gt;=lowerBound) (primes upperBound) </li>
        <li>grouped = group myPrimes </li>
        <li>-- This will return an example of the largest size of prime permutation group </li>
        <li>mostCommon = foldr (myMax) (0, []) grouped </li>
        <li> </li>
        <li>main = putStrLn (show mostCommon) </li>
        <li> </li>
        <li>-- for testing, compile with profiling: </li>
        <li>--   ghc --make Main.hs -prof -fprof-auto -o Main.exe </li>
        <li>--   main.exe +RTS -p </li>
        <li> </li>
        <li>-- prime generator </li>
        <li>primes n = sieve [2..n] </li>
        <li>	where  </li>
        <li>		sieve [] = [] </li>
        <li>		sieve (p:xs) = p : sieve (filter (\x -&gt; mod x p /= 0) xs) </li>
        <li> </li>
        <li>-- provided quicksort </li>
        <li>quicksort :: (Ord a) =&gt; [a] -&gt; [a]   </li>
        <li>quicksort [] = []   </li>
        <li>quicksort (x:xs) =    </li>
        <li>    let smallerSorted = quicksort [a | a &lt;- xs, a &lt;= x]   </li>
        <li>        biggerSorted = quicksort [a | a &lt;- xs, a &gt; x]   </li>
        <li>    in  smallerSorted ++ [x] ++ biggerSorted   </li>
        <li> </li>
        <li>-- key generator </li>
        <li>key n = quicksort (show n) </li>
        <li> </li>
        <li>-- grouping digits (This one is the time killer.) </li>
        <li>group [] = [] </li>
        <li>group (x:xs) =  </li>
        <li>    let matches = [e | e &lt;- xs, key x == key e] </li>
        <li>        others = group ( [e | e &lt;- xs, key x /= key e] ) </li>
        <li>    in (length matches + 1, x : matches) : others </li>
        <li> </li>
        <li>-- sorting criteria </li>
        <li>myMax a b =  </li>
        <li>	if fst a &gt; fst b </li>
        <li>		then a </li>
        <li>		else b </li>
      </ol></div>
      <p>Another cool thing about Haskell is that it comes with a fancy profiler.  I ran it on my program and it gave me this as the result:</p>
      <div class="center"><img src="/assets/articles/linguistics/haskell_prof.png"></div>
      <p>All in all it was a really insightful exploration into another programming language.</p>
    </div>
    <h2 onclick="toggleCollapse('javascript');">JavaScript</h2>
    <div class="collapsing collapsed" onclick="toggleCollapse('javascript');" id="javascript">
      <p>JavaScript is written to do the same thing as C++, but instead of using a bitset, it generates a list of primes.  That means each prime is a Number and not a single bit.  What JavaScript does bring to the table to is integration with HTML, and the ability to easily make the code visually interactive, with a GUI.</p>
      <div class="widthLimit"><ol class="code heightLimit">
        <li>//This is meant to find the largest cluster </li>
        <li>// of 7 digit primes that are all permutations </li>
        <li>// of each other. </li>
        <li> </li>
        <li>function getPrimes(upperBound, lowerBound) { </li>
        <li>    isPrime = [] </li>
        <li>    isPrime.length = upperBound </li>
        <li>    for (i=0; i &lt; upperBound; ++i) { </li>
        <li>        isPrime[i] = true; </li>
        <li>    } </li>
        <li> </li>
        <li>    limit = Math.ceil(Math.sqrt(10)); </li>
        <li>    for (i = 2; i &lt; isPrime.length; ++i) { </li>
        <li>        if (isPrime[i] == true) { </li>
        <li>            for (j = i*i; j &lt; upperBound; j += i) { </li>
        <li>                isPrime[j] = false; </li>
        <li>            } </li>
        <li>        } </li>
        <li>    } </li>
        <li> </li>
        <li>    primes = [] </li>
        <li>    for (i = 2; i &lt; isPrime.length; ++i) { </li>
        <li>        if (isPrime[i] == true && i &gt; lowerBound) { </li>
        <li>            primes.push(i); </li>
        <li>        } </li>
        <li>    } </li>
        <li>    return primes </li>
        <li>} </li>
        <li> </li>
        <li>function getKey(n) { </li>
        <li>    key = 0 </li>
        <li>    while (n &gt; 0) { </li>
        <li>        key += Math.pow(10, (n%10)) </li>
        <li>        n = Math.floor(n / 10) </li>
        <li>    } </li>
        <li>    return key </li>
        <li>} </li>
        <li> </li>
        <li> </li>
        <li>function getPrimePermutations() { </li>
        <li> </li>
        <li>    primes = getPrimes(document.getElementById("upperBound").value, document.getElementById("lowerBound").value); </li>
        <li> </li>
        <li>    // group primes by permutations </li>
        <li>    matches = {} </li>
        <li>    for (i in primes) { </li>
        <li>        if (typeof matches[getKey(primes[i])] === "undefined") { </li>
        <li>            matches[getKey(primes[i])] = [primes[i]]; </li>
        <li>        } else { </li>
        <li>            matches[getKey(primes[i])].push(primes[i]); </li>
        <li>        } </li>
        <li>    } </li>
        <li> </li>
        <li>    // find the highest count of prime permutations </li>
        <li>    // and all digits that match that count </li>
        <li>    max = [[]] </li>
        <li>    for (i in matches) { </li>
        <li>        if (matches[i].length &gt; max[0].length) { </li>
        <li>            max = [matches[i]] </li>
        <li>        } else if (matches[i].length == max[0].length) { </li>
        <li>            max.push(matches[i]) </li>
        <li>        } </li>
        <li>    } </li>
        <li> </li>
        <li>    document.getElementById("result").innerHTML="&lt;p&gt;Max length: " + max[0].length + " primes&lt;/p&gt;&lt;p&gt;Number of matches: " + max.length + "&lt;/p&gt;"; </li>
        <li>    result = "&lt;ul&gt;"; </li>
        <li>    for (i in max) { </li>
        <li>        result += "&lt;li&gt;" + max[i] + "&lt;/li&gt;"; </li>
        <li>    } </li>
        <li>    result += "&lt;/ul&gt;" </li>
        <li>    document.getElementById("values").innerHTML=result; </li>
        <li>} </li>
      </ol></div>
      <div class="widthLimit">
        <div id="input">
                <label for="lowerBound">Lower bound</label>
                <input type="text" name="lowerBound" id="lowerBound" value="1000"></input><br />
                <label for="upperBound">Upper bound</label>
                <input type="text" name="upperBound" id="upperBound" value="9999"></input><br />
                <input type="submit" value="Find the most prime permutations" onclick="getPrimePermutations()"></input>
        </div>
        <div id="result"></div>
        <div id="values"></div>
      </div>
      <p>It takes several seconds to calculate the answer for 7 digits, considerably slower than the C++ version, but not as much slower as I expected.  I was pleasantly surprised!</p>
    </div>
    <h2 onclick="toggleCollapse('powershell');">PowerShell</h2>
    <div class="collapsing collapsed" onclick="toggleCollapse('powershell');" id="powershell">
      <p>It took a little bit to wrap my head around PowerShell being built for piping commands into commands, but it is actually really cool, and powerful.  I had a working product in PowerShell faster than in any other language.</p>
      <div class="widthLimit"><ol class="code heightLimit">
        <li>Function GetKey ($n) </li>
        <li>{ </li>
        <li>    $key = 0 </li>
        <li>    while ($n -gt 0) </li>
        <li>    { </li>
        <li>        $key += [Math]::Pow(10, $n % 10) </li>
        <li>        $n = ([Math]::Floor($n / 10)) </li>
        <li>    } </li>
        <li>    return $key </li>
        <li>} </li>
        <li> </li>
        <li>Function GetFilteredPrimes </li>
        <li>{ </li>
        <li>    Param ([int]$upper, [int]$lower) </li>
        <li>    $primes = (0..($upper)) </li>
        <li>    $result = @() </li>
        <li>    for ($i = 2; $i -lt $upper; ++$i)  </li>
        <li>    { </li>
        <li>        if ($primes[$i] -ne 0) </li>
        <li>        { </li>
        <li>            if ($primes[$i] -ge $lower) </li>
        <li>            { </li>
        <li>                $result += $i </li>
        <li>            } </li>
        <li>            for ($j = $i*$i; $j -le $upper; $j += $i) </li>
        <li>            { </li>
        <li>                $primes[$j] = 0 </li>
        <li>            } </li>
        <li>        } </li>
        <li>    } </li>
        <li>    return $result </li>
        <li>} </li>
        <li>GetFilteredPrimes 999999 100000 | Group-Object {getkey($_)} | Sort-Object Count | Select -Last 1 </li>
      </ol></div>
      <p>I was not patient enough to see how long it would take to calculate the 7-digit number, but 6 digits took about 4 minutes.  Getting the primes was the most expensive part at 3 minutes, and grouping them took a minute more.  I read a little about how to profile and optimize, but did not get far.  I read that using things like [Math]::Pow() load up C# libraries, but avoiding C# did not appear to make a difference to computation times.  Interesting experiment, and PowerShell is kind of fun, but I don’t have need for its strengths right now.</p>
    </div>
    <h2 onclick="toggleCollapse('python');">Python</h2>
    <div class="collapsing collapsed" onclick="toggleCollapse('python');" id="python">
      <p>Python is a favorite of mine, so naturally I wrote up the program here too.</p>
      <div class="widthLimit"><ol class="code heightLimit">
        <li>import math </li>
        <li> </li>
        <li>def main(): </li>
        <li>    primes = getPrimes(10000000, 1000000) </li>
        <li> </li>
        <li>    matches = {} </li>
        <li> </li>
        <li>    # group primes by permutations </li>
        <li>    key = 0 </li>
        <li>    for prime in primes: </li>
        <li>        key = getKey(prime) </li>
        <li>        if key in matches: </li>
        <li>            matches[key].append(prime) </li>
        <li>        else: </li>
        <li>            matches[key] = [prime] </li>
        <li> </li>
        <li>    # find the highest count of prime permutations </li>
        <li>    # and all digits that match that count </li>
        <li>    max = [0, []] </li>
        <li>    for match in matches.items(): </li>
        <li>        if len(match[1]) &gt; max[0]: </li>
        <li>            max[0] = len(match[1]) </li>
        <li>            max[1] = [match] </li>
        <li>        elif len(match[1]) == max[0]: </li>
        <li>            max[1].append(match) </li>
        <li> </li>
        <li>    # report the answer, and all prime permutations </li>
        <li>    print("max: %d permutations. (%d matches)" % (max[0], len(max[1]))) </li>
        <li>    for i in max[1]: </li>
        <li>        print("%d:" % i[0], i[1]) </li>
        <li> </li>
        <li>def getKey(n): </li>
        <li>    key = 0 </li>
        <li>    while n &gt; 0: </li>
        <li>        key += 10 ** (n%10) </li>
        <li>        n //= 10 </li>
        <li>    return key; </li>
        <li> </li>
        <li>def getPrimes(maxVal, minVal=0): </li>
        <li>    primes = list(range(maxVal)) </li>
        <li>    limit = int(math.ceil(maxVal ** 0.5) + 1) </li>
        <li>    for i in primes[2:limit]: </li>
        <li>        if i != 0: </li>
        <li>            for j in range(i*i, maxVal, i): </li>
        <li>                primes[j] = 0 </li>
        <li>    return [i for i in primes if i != 0 and i &gt; minVal] </li>
        <li> </li>
        <li>if __name__ == "__main__": </li>
        <li>    main() </li>
      </ol></div>
      <p>Python 2.7.6 and 3.3.3 both took about 10 seconds to calculate the result.  I confess I'm a little upset that it's not running faster than the javascript edition.  I like python, and may have to fiddle with this to improve it.</p>
    </div>
  <div class="endFloat">&nbsp;</div></div>
