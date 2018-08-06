  <div id="SectionContainer">
    <h1>Rix Compiler</h1>
    <p>TODO: build compiler</p>
  </div>
  <div class="content">
    <div class="center"><img src="/assets/articles/rix/flow.jpg"></div>
    <p>The Rix Compiler is a project that was undertaken as a student at BCIT in the fall of 2015.  We were a team of three students and the project came to us from an external client who was himself a developer.  The language in question was meant to be easy to use like python, statically typed, and as fast and powerful as C.  Our objective was to test, fix, and implement objects and single inheritance into the compiler. Incidentally, none of us had any understanding of the inner workings of compilers. </p>
    <p>It turns out compilers are generally split into several discrete tasks. Lexical analysis, parsing, building a syntax tree, and generating code in the output language. For this project we had to touch all those areas and also manage the scope and symbol table, and type-checking.  The output language was C though, so no assembly or machine code was needed, and we didn’t touch optimization in any way.</p>
    <h2>Lexical Analysis</h2>
    <p>Lexical analysis (lexing) is the process of turning a string of characters into tokens.  Basically you crawl through the text files character by character and when your string of characters makes a complete token you pass it forward to the next compiler phase.  An English comparison would be connecting the letters of this sentence into words, broken up by spaces and punctuated with periods and commas.  The following Rix example:</p>
    <div class="widthLimit"><ol class="code heightLimit">
      <li>n = 5</li>
      <li>i for 1, n + 1</li>
      <li>    print i</li>
    </ol></div>
    <p>might be broken up into the following tokens:</p>
    <!--<div class="center"><table><tr>
      <td>n</td>
      <td>=</td>
      <td>5</td>
      <td>EOL</td>
      <td>i</td>
      <td>for</td>
      <td>1</td>
      <td>,</td>
      <td>n</td>
      <td>+</td>
      <td>1</td>
      <td>EOL</td>
      <td>indent</td>
      <td>print</td>
      <td>i</td>
      <td>EOL</td>
      <td>unindent</td>
      <td>EOF</td>
    </tr></table></div>-->
    <div class="center blocks"><div>n</div><div>=</div><div>5</divdiv>EOL</div><div>i</div><div>for</div><div>1</div><div>,</div><div>n</div><div>+</div><div>1</div><div>EOL</div><div>indent</div><div>print</div><div>i</div><div>EOL</div><div>unindent</div><div>EOF</div></div>
    <p>The lexer has some vague idea what these tokens are, when viewed in isolation; It recognizes that = is the equality operator, and “print” is the name of some function or variable. However, the lexer has no idea which tokens relate to which others. It just converts the string of characters into a string of tokens for the next process: parsing.</p>
    <h2>Parsing</h2>
    <p>Parsing takes the tokens from the lexer and connects them into combinations that start to have some meaning. It tries to match sequences of tokens against a set of patterns it recognizes.  For example, in English you often form sentences out of a sequence of tokens like subject, verb, object, period. It’s not the only way to build a sentence but it’s one of the patterns the parser would match.</p>
    <p>In Rix, the parser tries to form statements in a similar subject-verb-object format, followed by a newline. <span class="code">n = 5 EOL</span> would be parsed as a complete statement in itself.</p>
    <div class="center"><table><tr>
      <td>n</td>
      <td>=</td>
      <td>5</td>
      <td>EOL</td>
    </tr><tr class="descriptive">
      <td>subject</td>
      <td>verb</td>
      <td>object</td>
      <td>period</td>
    </tr></table></div>
    <p>The same sort of thing would happen in <span class="code">i for 1, n+1</span>, where the object itself has a nested subject-verb-object.  This is I believe the most complicated sort of deterministic string processing that is done in programming.  To build this entire parsing engine--and the lexer--from just C's standard library would be a great challenge and long project in itself.  Gratefully, the <acronym title="Free Software Foundation">FSF</acronym> and open source community came to our rescue.</p>
    <h2>There's an app for that</h2>
    <p>There are two amazing tools out there called <a href="http://flex.sourceforge.net">flex</a> and <a href="https://www.gnu.org/software/bison/">Bison</a>.  They each take a custom  rulebook you provide and compile those rules into C or C++ compatible code.  From there, you can add those projects to your build and bam! lexing and parsing are done! Of course, defining the <span class="italic">right</span> rules is not as easy as it sounds.</p>
    <p>Flex operates by applying regular expressions (and some more elaborate rules) to the input file to translate into tokens. Bison takes something similar to regular expressions applied to tokens to let us define recursive patterns.</p>
    <p>this is where a language definition technique called EBNF (Extended Backus-Naur Format) comes into play.  You define a symbol that represents any program, and then what that program can be made up of, similar to XML DTDs. This repeats recursively until you’re down to symbols that are made up of the tokens that the lexer is spitting out.  </p>
    <p>A simplified EBNF for Rix might look something like this:</p>
    <div class="widthLimit">
      <dl>
        <dt>rix-program = </dt><dd>statements+, EOF</dd>
        <dt>statements = </dt><dd>class-definition | function-definition | statement | (indent, statement, unindent) | EOL</dd>
        <dt>statement = </dt><dd>subject?, verb, object, (comma, object)*, EOL</dd>
        <dt>subject = </dt><dd>integer | float | variable | ...</dd>
        <dt>verb = </dt><dd>function | plus | minus | equals | ...</dd>
        <dt>object = </dt><dd>integer | float | variable | statement | ...</dd>
        <dt>function-definition = </dt><dd>function-header, indent, statement+ unindent</dd>
        <dt>class-definition = </dt><dd>class-header, indent, state*, function-definition*, unindent</dd>
      </dl>
    </div>
    <p>This is really cool! Once you have a dictionary like this, denoting what comprises what else, you can directly build a tree out of your program! You just connect the tokens until a pattern matches, then connect patterns until another pattern matches, until you can match the whole input file to a rix-program. etc. Remember that Rix code we saw earlier?</p>
    <div class="widthLimit"><ol class="code heightLimit">
      <li>n = 5</li>
      <li>i for 1, n + 1</li>
      <li>    print i</li>
    </ol></div>
    <p>it deconstructs into something like this:</p>
    <figure>
      <div class="center" id="syntreeBox">
        <img src="/assets/articles/rix/syntree.png">
      </div><figcaption>Created using a <a href="http://mshang.ca/syntree/?i=%5Brix-program%20%0A%5Bstatements%20%5Bstatement%20%5Bsubject%20%5Bvariable%20%5Bn%5D%5D%5D%5Bverb%20%5Bequals%20%5D%5D%5Bobject%20%5Binteger%20%5B5%5D%5D%5D%5BEOL%5D%5D%5D%0A%0A%5Bstatements%20%5Bstatement%0A%5Bsubject%20%5Bvariable%5Bi%5D%5D%5D%0A%5Bverb%20%5Bfunction%5Bfor%5D%5D%5D%0A%5Bobject%20%5Binteger%5B1%5D%5D%5D%0A%5Bcomma%5D%0A%5Bobject%20%5Bstatement%5Bsubject%5Bvariable%5Bn%5D%5D%5D%5Bverb%5Bplus%5D%5D%5Bobject%5Binteger%5B1%5D%5D%5D%5D%5D%0A%5BEOL%5D%5D%5D%0A%0A%0A%0A%5Bstatements%20%0A%5Bindent%5D%20%0A%5Bstatement%20%5Bverb%5Bfunction%5Bprint%5D%5D%5D%5Bobject%5Bvariable%5Bi%5D%5D%5D%5BEOL%5D%5D%20%0A%5Bunindent%5D%0A%5D%0A%5BEOF%5D%0A%5D">JavaScript app</a> by Miles Shang</figcaption>
    </figure>
    <p>Once the parser has processed all the tokens into Rix syntax, it’s ready to test for errors (e.g. is this variable defined in this scope?) and generate the code for output.</p>
    <h2>The results are in</h2>
    <p>After a three months of design and development, we had written a compiler that could handle:</p>
    <div class="widthLimit"><ul>
      <li>Declaring variables and inferring the type</li>
      <li>Evaluating expressions</li>
      <li>Defining and calling functions with 0, 1, or more arguments</li>
      <li>White-space dependant syntax: indents define blocks and lines define complete statements.</li>
      <li>Conditional evaluation and loops</li>
      <li>A ‘?’ operator that stores the result of the last evaluation (for chained if;else if;else, but useable for more)</li>
      <li>Definable classes, with members, methods, and constructors</li>
      <li>Single inheritance for classes, with access to parent members/methods</li>
      <li>Class instantiation, member and parent access, including from within functions and invoking functions on classes</li>
    </ul></div>
    <p>Our client was thrilled, and after the project was complete he posted it on Reddit to get feedback from the community.  It generated a lot of interesting discussion, and some less-interesting PHP bashing, and even caused Rix (called Ritchie at the time) to become one of the trending GitHub repositories!</p>
    <div class="center"><img src="/assets/articles/rix/reddit.png"></div>
    <div class="center"><img src="/assets/articles/rix/github.png"></div>
    <h2>Creation and design work is exciting</h2>
    <p>This project was a serious stretch of brain power for me and it was the most exciting project I’d worked on to that date!  From learning and understanding the new topic of compiler architecture, to designing and implementing a solution to tracking scope and symbols, to figuring out a way to implement object-oriented programming in C it was an amazing experience.  The compiler has plenty more growing to do, and has continued to evolve since I completed my work on it.  Some of the next challenges are implementing generics, building up a standard library, and opening the language up for redefining all the built-in symbols so that Rix’s default dialect (behaviour) will be written in Rix itself and open to reimagining.</p>
    <p>For more information, check out the project on <a href="https://github.com/riolet/rix/">GitHub!</a></p>
  <div class="endFloat">&nbsp;</div></div>
