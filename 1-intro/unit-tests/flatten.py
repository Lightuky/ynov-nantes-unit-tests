#!/usr/bin/env python

"""
flatten function :
flatten an array of arbitrarily nested arrays of integers into a flat array of integers. e.g. [[1,2,[3]],4] -> [1,2,3,4]

ideally we should use numpy flatten method
https://docs.scipy.org/doc/numpy/reference/generated/numpy.ndarray.flatten.html

"""

def flatten(mylist):
    """Flatten an array of nested arrays of integers into a flat array of integers

    Parameters
    ----------
    mylist : list
        a list of int|list.

    Returns
    -------
    list
        a list of integers
    """
    result = []
    for element in mylist:
        if not (isinstance(element, int) or isinstance(element, list)):
            raise TypeError('parameter should contain only int|list')

        # if element is list of int
        if isinstance(element, list) and __are_element_only_numbers(element):
            result = result + element
        # if element is list of mixed types
        elif isinstance(element, list):
            result = result + flatten(element)
        # if element is int
        elif isinstance(element, int):
            result.append(element)
    return result

def __are_element_only_numbers(mylist):
    """Check if all elements in a list are int

    Parameters
    ----------
    mylist : list
        a list of int|list.

    Returns
    -------
    bool
        True if all value in list are int, False otherwise.
    """
    # if we have at least one elem to check
    only_numbers = True if len(mylist) > 0 else False
    for value in mylist:
        if not isinstance(value, int):
            only_numbers = False
    return only_numbers

