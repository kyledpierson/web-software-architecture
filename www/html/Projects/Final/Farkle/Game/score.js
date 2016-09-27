


function tallyScore(diceArray) {
	switch(diceArray.length) {
		case 1:
			if(includes(diceArray, [1]))
				return 100;
			else if(includes(diceArray, [5]))
				return 50;
			else
				return 0;
		case 2:
			if(includes(diceArray, [1, 1]))
				return 200;
			else if(includes(diceArray, [1, 5]))
				return 150;
			else if(includes(diceArray, [5, 5]))
				return 100;
			else
				return 0;
		case 3:
			if(includes(diceArray, [1, 1, 1]))
				return 1000;
			else if(includes(diceArray, [2, 2, 2]))
				return 200;
			else if(includes(diceArray, [3, 3, 3]))
				return 300;
			else if(includes(diceArray, [4, 4, 4]))
				return 400;
			else if(includes(diceArray, [5, 5, 5]))
				return 500;
			else if(includes(diceArray, [6, 6, 6]))
				return 600;
			else if(includes(diceArray, [1, 1, 5]))
				return 250;
			else if(includes(diceArray, [1, 5, 5]))
				return 200;
			else
				return 0;
		case 4:
			if(includes(diceArray, [1, 1, 1, 1]))
				return 2000;
			else if(includes(diceArray, [1, 2, 2, 2]))
				return 300;
			else if(includes(diceArray, [1, 3, 3, 3]))
				return 400;
			else if(includes(diceArray, [1, 4, 4, 4]))
				return 500;
			else if(includes(diceArray, [1, 5, 5, 5]))
				return 600;
			else if(includes(diceArray, [1, 6, 6, 6]))
				return 700;
			else if(includes(diceArray, [5, 1, 1, 1]))
				return 1050;
			else if(includes(diceArray, [5, 2, 2, 2]))
				return 250;
			else if(includes(diceArray, [5, 3, 3, 3]))
				return 350;
			else if(includes(diceArray, [5, 4, 4, 4]))
				return 450;
			else if(includes(diceArray, [5, 5, 5, 5]))
				return 1000;
			else if(includes(diceArray, [5, 6, 6, 6]))
				return 650;
			else if(includes(diceArray, [1, 1, 5, 5]))
				return 300;
			else if(includes(diceArray, [2, 2, 2, 2]))
				return 400;
			else if(includes(diceArray, [3, 3, 3, 3]))
				return 600;
			else if(includes(diceArray, [4, 4, 4, 4]))
				return 800;
			else if(includes(diceArray, [6, 6, 6, 6]))
				return 1200;
			else
				return 0;
		case 5:
			if(includes(diceArray, [1, 1, 1, 1, 1]))
				return 3000;
			else if(includes(diceArray, [1, 1, 2, 2, 2]))
				return 400;
			else if(includes(diceArray, [1, 1, 3, 3, 3]))
				return 500;
			else if(includes(diceArray, [1, 1, 4, 4, 4]))
				return 600;
			else if(includes(diceArray, [1, 1, 5, 5, 5]))
				return 700;
			else if(includes(diceArray, [1, 1, 6, 6, 6]))
				return 800;
			else if(includes(diceArray, [5, 5, 1, 1, 1]))
				return 1100;
			else if(includes(diceArray, [5, 5, 2, 2, 2]))
				return 300;
			else if(includes(diceArray, [5, 5, 3, 3, 3]))
				return 400;
			else if(includes(diceArray, [5, 5, 4, 4, 4]))
				return 500;
			else if(includes(diceArray, [5, 5, 5, 5, 5]))
				return 2000;
			else if(includes(diceArray, [5, 5, 6, 6, 6]))
				return 700;
			else if(includes(diceArray, [1, 5, 1, 1, 1]))
				return 1150;
			else if(includes(diceArray, [1, 5, 2, 2, 2]))
				return 350;
			else if(includes(diceArray, [1, 5, 3, 3, 3]))
				return 450;
			else if(includes(diceArray, [1, 5, 4, 4, 4]))
				return 550;
			else if(includes(diceArray, [1, 5, 5, 5, 5]))
				return 650;
			else if(includes(diceArray, [1, 5, 6, 6, 6]))
				return 750;
			else if(includes(diceArray, [2, 2, 2, 2, 2]))
				return 600;
			else if(includes(diceArray, [3, 3, 3, 3, 3]))
				return 900;
			else if(includes(diceArray, [4, 4, 4, 4, 4]))
				return 1200;
			else if(includes(diceArray, [6, 6, 6, 6, 6]))
				return 1800;
			else if(includes(diceArray, [2, 2, 2, 2, 1]))
				return 500;
			else if(includes(diceArray, [3, 3, 3, 3, 1]))
				return 700;
			else if(includes(diceArray, [4, 4, 4, 4, 1]))
				return 900;
			else if(includes(diceArray, [6, 6, 6, 6, 1]))
				return 1300;
			else if(includes(diceArray, [2, 2, 2, 2, 5]))
				return 450;
			else if(includes(diceArray, [3, 3, 3, 3, 5]))
				return 650;
			else if(includes(diceArray, [4, 4, 4, 4, 5]))
				return 850;
			else if(includes(diceArray, [6, 6, 6, 6, 5]))
				return 1250;
			else
				return 0;
		case 6:
			if(includes(diceArray, [1, 1, 1, 1, 1, 1]))
				return 2000;
			else if(includes(diceArray, [2, 2, 2, 2, 2, 2]))
				return 1000;
			else if(includes(diceArray, [3, 3, 3, 3, 3, 3]))
				return 1000;
			else if(includes(diceArray, [4, 4, 4, 4, 4, 4]))
				return 1000;
			else if(includes(diceArray, [5, 5, 5, 5, 5, 5]))
				return 1000;
			else if(includes(diceArray, [6, 6, 6, 6, 6, 6]))
				return 1000;
			else if(includes(diceArray, [1, 2, 3, 4, 5, 6]))
				return 1500;
			else if(includes(diceArray, [1, 1, 2, 2, 3, 3])) // 0
				return 1000;
			else if(includes(diceArray, [1, 1, 2, 2, 4, 4])) // 1
				return 1000;
			else if(includes(diceArray, [1, 1, 2, 2, 5, 5])) // 2
				return 1000;
			else if(includes(diceArray, [1, 1, 2, 2, 6, 6])) // 3
				return 1000;
			else if(includes(diceArray, [1, 1, 3, 3, 4, 4])) // 4
				return 1000;
			else if(includes(diceArray, [1, 1, 3, 3, 5, 5])) // 5
				return 1000;
			else if(includes(diceArray, [1, 1, 3, 3, 6, 6])) // 6
				return 1000;
			else if(includes(diceArray, [1, 1, 4, 4, 5, 5])) // 7
				return 1000;
			else if(includes(diceArray, [1, 1, 4, 4, 6, 6])) // 8
				return 1000;
			else if(includes(diceArray, [1, 1, 5, 5, 6, 6])) // 9
				return 1000;
			else if(includes(diceArray, [2, 2, 3, 3, 4, 4])) // 10
				return 1000;
			else if(includes(diceArray, [2, 2, 3, 3, 5, 5])) // 11
				return 1000;
			else if(includes(diceArray, [2, 2, 3, 3, 6, 6])) // 12
				return 1000;
			else if(includes(diceArray, [2, 2, 4, 4, 5, 5])) // 13
				return 1000;
			else if(includes(diceArray, [2, 2, 4, 4, 6, 6])) // 14
				return 1000;
			else if(includes(diceArray, [2, 2, 5, 5, 6, 6])) // 15
				return 1000;
			else if(includes(diceArray, [3, 3, 4, 4, 5, 5])) // 16
				return 1000;
			else if(includes(diceArray, [3, 3, 4, 4, 6, 6])) // 17
				return 1000;
			else if(includes(diceArray, [3, 3, 5, 5, 6, 6])) // 18
				return 1000;
			else if(includes(diceArray, [4, 4, 5, 5, 6, 6])) // 19
				return 1000;
			else if(includes(diceArray, [1, 1, 2, 2, 2, 2])) // 0
				return 1000;
			else if(includes(diceArray, [1, 1, 3, 3, 3, 3])) // 1
				return 1000;
			else if(includes(diceArray, [1, 1, 4, 4, 4, 4])) // 2
				return 1000;
			else if(includes(diceArray, [1, 1, 5, 5, 5, 5])) // 3
				return 1000;
			else if(includes(diceArray, [1, 1, 6, 6, 6, 6])) // 4
				return 1000;
			else if(includes(diceArray, [2, 2, 1, 1, 1, 1])) // 5
				return 1000;
			else if(includes(diceArray, [2, 2, 3, 3, 3, 3])) // 6
				return 1000;
			else if(includes(diceArray, [2, 2, 4, 4, 4, 4])) // 7
				return 1000;
			else if(includes(diceArray, [2, 2, 5, 5, 5, 5])) // 8
				return 1000;
			else if(includes(diceArray, [2, 2, 6, 6, 6, 6])) // 9
				return 1000;
			else if(includes(diceArray, [3, 3, 1, 1, 1, 1])) // 10
				return 1000;
			else if(includes(diceArray, [3, 3, 2, 2, 2, 2])) // 11
				return 1000;
			else if(includes(diceArray, [3, 3, 4, 4, 4, 4])) // 12
				return 1000;
			else if(includes(diceArray, [3, 3, 5, 5, 5, 5])) // 13
				return 1000;
			else if(includes(diceArray, [3, 3, 6, 6, 6, 6])) // 14
				return 1000;
			else if(includes(diceArray, [4, 4, 1, 1, 1, 1])) // 15
				return 1000;
			else if(includes(diceArray, [4, 4, 2, 2, 2, 2])) // 16
				return 1000;
			else if(includes(diceArray, [4, 4, 3, 3, 3, 3])) // 17
				return 1000;
			else if(includes(diceArray, [4, 4, 5, 5, 5, 5])) // 18
				return 1000;
			else if(includes(diceArray, [4, 4, 6, 6, 6, 6])) // 19
				return 1000;
			else if(includes(diceArray, [5, 5, 1, 1, 1, 1])) // 20
				return 1000;
			else if(includes(diceArray, [5, 5, 2, 2, 2, 2])) // 21
				return 1000;
			else if(includes(diceArray, [5, 5, 3, 3, 3, 3])) // 22
				return 1000;
			else if(includes(diceArray, [5, 5, 4, 4, 4, 4])) // 23
				return 1000;
			else if(includes(diceArray, [5, 5, 6, 6, 6, 6])) // 24
				return 1000;
			else if(includes(diceArray, [6, 6, 1, 1, 1, 1])) // 25
				return 1000;
			else if(includes(diceArray, [6, 6, 2, 2, 2, 2])) // 26
				return 1000;
			else if(includes(diceArray, [6, 6, 3, 3, 3, 3])) // 27
				return 1000;
			else if(includes(diceArray, [6, 6, 4, 4, 4, 4])) // 28
				return 1000;
			else if(includes(diceArray, [6, 6, 5, 5, 5, 5])) // 29
				return 1000;
			else if(includes(diceArray, [1, 1, 1, 2, 2, 2]))
				return 1200;
			else if(includes(diceArray, [1, 1, 1, 3, 3, 3]))
				return 1300;
			else if(includes(diceArray, [1, 1, 1, 4, 4, 4]))
				return 1400;
			else if(includes(diceArray, [1, 1, 1, 5, 5, 5])) 
				return 1500;
			else if(includes(diceArray, [1, 1, 1, 6, 6, 6]))
				return 1600;
			else if(includes(diceArray, [2, 2, 2, 3, 3, 3]))
				return 500;
			else if(includes(diceArray, [2, 2, 2, 4, 4, 4]))
				return 600;
			else if(includes(diceArray, [2, 2, 2, 5, 5, 5]))
				return 700;
			else if(includes(diceArray, [2, 2, 2, 6, 6, 6]))
				return 800;
			else if(includes(diceArray, [3, 3, 3, 4, 4, 4]))
				return 700;
			else if(includes(diceArray, [3, 3, 3, 5, 5, 5]))
				return 800;
			else if(includes(diceArray, [3, 3, 3, 6, 6, 6]))
				return 900;
			else if(includes(diceArray, [4, 4, 4, 5, 5, 5]))
				return 900;
			else if(includes(diceArray, [4, 4, 4, 6, 6, 6]))
				return 1000;
			else if(includes(diceArray, [5, 5, 5, 6, 6, 6])) 
				return 1100;
			else if(includes(diceArray, [2, 2, 2, 1, 5, 5])) 
				return 400;
			else if(includes(diceArray, [2, 2, 2, 1, 1, 5])) 
				return 450;
			else if(includes(diceArray, [3, 3, 3, 1, 5, 5])) 
				return 500;
			else if(includes(diceArray, [3, 3, 3, 1, 1, 5])) 
				return 550;
			else if(includes(diceArray, [4, 4, 4, 1, 5, 5])) 
				return 600;
			else if(includes(diceArray, [4, 4, 4, 1, 1, 5])) 
				return 650;
			else if(includes(diceArray, [6, 6, 6, 1, 5, 5])) 
				return 800;
			else if(includes(diceArray, [6, 6, 6, 1, 1, 5])) 
				return 850;
			else if(includes(diceArray, [2, 2, 2, 2, 1, 5])) 
				return 550;
			else if(includes(diceArray, [3, 3, 3, 3, 1, 5])) 
				return 750;
			else if(includes(diceArray, [4, 4, 4, 4, 1, 5])) 
				return 950;
			else if(includes(diceArray, [6, 6, 6, 6, 1, 5])) 
				return 1350;
			else if(includes(diceArray, [2, 2, 2, 2, 2, 1])) 
				return 700;
			else if(includes(diceArray, [2, 2, 2, 2, 2, 5])) 
				return 650;
			else if(includes(diceArray, [3, 3, 3, 3, 3, 1])) 
				return 1000;
			else if(includes(diceArray, [3, 3, 3, 3, 3, 5])) 
				return 950;
			else if(includes(diceArray, [4, 4, 4, 4, 4, 1])) 
				return 1300;
			else if(includes(diceArray, [4, 4, 4, 4, 4, 5])) 
				return 1250;
			else if(includes(diceArray, [6, 6, 6, 6, 6, 1])) 
				return 1900;
			else if(includes(diceArray, [6, 6, 6, 6, 6, 5])) 
				return 1850;
			else
				return 0;
		default:
			return 0;
	}
}

function includes(diceArray, array) {
	a1 = diceArray.sort();
	a2 = array.sort();
	for(var i = 0; i < array.length; i++)
	{
		if(array[i] != diceArray[i])
			return false;
	
	}
	return true;
}

function farkle_test(diceArray) {
	var doubles = 0;
	var dice = {};
	dice[2] = 0;
	dice[3] = 0;
	dice[4] = 0;
	dice[6] = 0;
	for(var i = 0; i < diceArray.length; i++)
		if(diceArray[i] == 1 || diceArray[i] == 5)
			return false;
		else
			dice[diceArray[i]]+=1;
	for(var key in dice)
		if(dice[key] == 3)
			return false;
		else if(dice[key] == 2)
			doubles+=1;
		else if(dice[key] >= 3)
			return false
	if(doubles == 3)	
		return false;
	else
		return true;
}
