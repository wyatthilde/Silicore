/* * *****************************************************************************
 * File Name: navigation.js
 * Project: Sandbox
 * Author: mnutsch
 * Edited 4-11-2017
 * Description: This file contains javascript code related to the navigation menu.
 * Notes: 
 * **************************************************************************** */
 
 /**************************************************************************
* Name: navigation menu hiding and displaying links
* Author: Matt Nutsch
* Date: 3-27-2017
* Description: This code handles hiding or displaying menu items based on class.
**************************************************************************/
function navHover(argClassName)
{
    //do nothing - added to temporarily prevent error messages in the JavaScript console
}
/*
//dev note: This code was disabled to make the nav menu less jumpy.
function navHover(argClassName)
{
    //argClassName contains all classes of the menu item
    //the first class listed is the unique class of that top level menu item
	
    //set varFirstClass to the first class in the element
    varFirstClass = argClassName.split(" ")[0];

    //set currentGroup to the class name of the current page
    var currentGroupLinks = document.getElementsByClassName("nav-left-link-current");
    var currentGroup = currentGroupLinks[0].className.split(" ")[0];

    //console.log("Top level menu item hovered: " + varFirstClass);
    
    //hide all indented navigation links
    var x = document.getElementsByClassName("nav-child-level");
    var i;
    for (i = 0; i < x.length; i++) 
    {
    	x[i].style.display = "none";
    }
    
    //show all indented navigation links of this parent item
    //x and i defined above
    x = document.getElementsByClassName(varFirstClass);
    for (i = 0; i < x.length; i++) 
    {
    	//console.log("unhiding element due to menu hover");
    	//console.log(x[i].className);
    	var isChild = x[i].className.includes("nav-child-level");
    	var isCurrentGroup = x[i].className.includes(currentGroup);
    	if(isChild == true)
    	{	
            if(isCurrentGroup == false)
            {
            	x[i].style = "-webkit-animation: fadeIn 0.5s; -moz-animation: fadeIn 0.5s; -o-animation: fadeIn 0.5s; animation: fadeIn 0.5s;";
            }
	}
	//x[i].style.display = "block";
    }
	
    //show all navigation links of the current page
    //x and i defined above
    x = document.getElementsByClassName(currentGroup);
    for (i = 0; i < x.length; i++) 
    {
    	//console.log("unhiding element due to current page");
	x[i].style.display = "block";
	//x[i].style = "-webkit-animation: fadeIn 0.5s; animation: fadeIn 0.5s;";
    }
}
*/

//onload hide all of the children navigation links, except for the current group
document.addEventListener('DOMContentLoaded', function() 
{
    //console.log("Initializing the menu.");
	
    //set currentGroup to the class name of the current page
    var currentGroupLinks = document.getElementsByClassName("nav-left-link-current");
    var currentGroup = currentGroupLinks[0].className.split(" ")[1];
    
    //hide all indented navigation links
    var x = document.getElementsByClassName("nav-child-level");
    var i;
    for (i = 0; i < x.length; i++) 
    {
        //console.log("hiding nav link");

        //if the indented navigation link is in the same group as the current link
        if((x[i].className.split(" ")[1] == currentGroup) || (x[i].className.split(" ")[1] == currentGroupLinks[0].className.split(" ")[0]))
        {
          //do nothing
        }
        else
        {
            //hide the submenu link
            x[i].style.display = "none";
        }
    }
    
}, false);

function resetMenu() 
{
    //do nothing - added to temporarily prevent error messages in the JavaScript console
}
/*
//dev note: This code was disabled to make the nav menu less jumpy.
//used to close child menu items when the user hovers over the main content portion of the page
function resetMenu() 
{
    //console.log("Initializing the menu.");
	
    //set currentGroup to the class name of the current page
    var currentGroupLinks = document.getElementsByClassName("nav-left-link-current");
    var currentGroup = currentGroupLinks[0].className.split(" ")[0];
	
    //hide all indented navigation links
    var x = document.getElementsByClassName("nav-child-level");
    var i;
    for (i = 0; i < x.length; i++) 
    {
    	x[i].style.display = "none";
    }
	
    //show all navigation links of the current page
    //x and i defined above
    x = document.getElementsByClassName(currentGroup);
    for (i = 0; i < x.length; i++) 
    {
    	//console.log("unhiding element due to current page");
    	x[i].style.display = "block";
    	//x[i].style = "-webkit-animation: fadeIn 0.5s; animation: fadeIn 0.5s;";
    }
	
}
*/