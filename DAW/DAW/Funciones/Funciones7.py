
def square(arr):
    for x in arr:
        yield x*x

arr = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
print(list(square(arr)))