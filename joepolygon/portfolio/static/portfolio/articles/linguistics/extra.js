//This is meant to find the largest cluster
// of 7 digit primes that are all permutations
// of each other.

function getPrimes(upperBound, lowerBound) {
    isPrime = []
    isPrime.length = upperBound
    for (i=0; i < upperBound; ++i) {
        isPrime[i] = true;
    }

    limit = Math.ceil(Math.sqrt(10));
    for (i = 2; i < isPrime.length; ++i) {
        if (isPrime[i] == true) {
            for (j = i*i; j < upperBound; j += i) {
                isPrime[j] = false;
            }
        }
    }

    primes = []
    for (i = 2; i < isPrime.length; ++i) {
        if (isPrime[i] == true && i > lowerBound) {
            primes.push(i);
        }
    }
    return primes
}

function getKey(n) {
    key = 0
    while (n > 0) {
        key += Math.pow(10, (n%10))
        n = Math.floor(n / 10)
    }
    return key
}


function getPrimePermutations() {

    primes = getPrimes(document.getElementById("upperBound").value, document.getElementById("lowerBound").value);

    // group primes by permutations
    matches = {}
    for (i in primes) {
        if (typeof matches[getKey(primes[i])] === "undefined") {
            matches[getKey(primes[i])] = [primes[i]];
        } else {
            matches[getKey(primes[i])].push(primes[i]);
        }
    }

    // find the highest count of prime permutations
    // and all digits that match that count
    max = [[]]
    for (i in matches) {
        if (matches[i].length > max[0].length) {
            max = [matches[i]]
        } else if (matches[i].length == max[0].length) {
            max.push(matches[i])
        }
    }

    document.getElementById("result").innerHTML="<p>Max length: " + max[0].length + " primes</p><p>Number of matches: " + max.length + "</p>";
    result = "<ul>";
    for (i in max) {
        result += "<li>" + max[i] + "</li>";
    }
    result += "</ul>"
    document.getElementById("values").innerHTML=result;
}
