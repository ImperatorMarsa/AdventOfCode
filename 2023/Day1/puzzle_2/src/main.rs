use core::panic;
use std::{
    fs::File,
    io::{self, BufRead},
    path::Path,
};

fn main() {
    match read_lines("input/input.txt") {
        Ok(lines) => {
            let mut result = 0;
            for line in lines {
                match line {
                    Ok(raw_calibration_value) => {
                        let calibration_value = build_calibration_val(get_numbers_from_string(
                            normalyze_numer(raw_calibration_value),
                        ));

                        if calibration_value.is_empty() {
                            continue;
                        }
                        match calibration_value.parse::<u32>() {
                            Ok(number) => result += number,
                            Err(error) => {
                                panic!("This {} is not number!!: {:?}", calibration_value, error)
                            }
                        };
                    }
                    Err(error) => panic!("Can't read from line: {:?}", error),
                };
            }

            println!("The sum of all of the calibration values: {}", result);
        }
        Err(error) => panic!("Can't read from file: {:?}", error),
    }
}

fn read_lines<P>(filename: P) -> io::Result<io::Lines<io::BufReader<File>>>
where
    P: AsRef<Path>,
{
    let file = File::open(filename)?;
    Ok(io::BufReader::new(file).lines())
}

fn get_numbers_from_string(line: String) -> String {
    let mut line_chars = line.chars();
    let mut numbers = String::new();
    loop {
        match line_chars.next() {
            Some(result) => {
                let tmp_string = String::from(result);
                match tmp_string.parse::<u32>() {
                    Ok(_) => numbers.push(result),
                    Err(_) => (),
                };
            }
            None => {
                break;
            }
        };
    }

    return numbers;
}

#[test]
fn get_numbers_from_string_test() {
    assert_eq!(
        get_numbers_from_string("1abc2".to_string()),
        "12".to_string()
    );
    assert_eq!(
        get_numbers_from_string("pqr3stu8vwx".to_string()),
        "38".to_string()
    );
    assert_eq!(
        get_numbers_from_string("a1b2c3d4e5f".to_string()),
        "12345".to_string()
    );
    assert_eq!(
        get_numbers_from_string("treb7uchet".to_string()),
        "7".to_string()
    );
}

fn build_calibration_val(nubmer: String) -> String {
    match nubmer.chars().count() {
        0 => "".to_string(),
        1 => format!("{}{}", nubmer, nubmer),
        2 => nubmer,
        _ => {
            let (first_diget, other_digets) = nubmer.split_at(1);
            let (_, last_diget) = other_digets.split_at(other_digets.chars().count() - 1);

            return format!("{}{}", first_diget, last_diget);
        }
    }
}

#[test]
fn build_calibration_val_test() {
    assert_eq!(build_calibration_val("12".to_string()), "12".to_string());
    assert_eq!(build_calibration_val("38".to_string()), "38".to_string());
    assert_eq!(build_calibration_val("12345".to_string()), "15".to_string());
    assert_eq!(build_calibration_val("7".to_string()), "77".to_string());
}

fn normalyze_numer(line: String) -> String {
    let mut line = line;

    let string_to_number_dictyonary = [
        ("1".to_string(), "one".to_string()),
        ("2".to_string(), "two".to_string()),
        ("3".to_string(), "three".to_string()),
        ("4".to_string(), "four".to_string()),
        ("5".to_string(), "five".to_string()),
        ("6".to_string(), "six".to_string()),
        ("7".to_string(), "seven".to_string()),
        ("8".to_string(), "eight".to_string()),
        ("9".to_string(), "nine".to_string()),
    ];

    for dictyonary in &string_to_number_dictyonary {
        let (number, string_number_alias) = dictyonary;
        if !line.contains(string_number_alias) {
            continue;
        }

        line = line.replace(string_number_alias, number);
    }

    return line;
}

#[test]
fn normalyze_numer_test() {
    assert_eq!("11".to_string(), normalyze_numer("oneone".to_string()));
    assert_eq!("219".to_string(), normalyze_numer("two1nine".to_string()));
    assert_eq!(
        "823".to_string(),
        normalyze_numer("eightwothree".to_string())
    );
    assert_eq!(
        "123".to_string(),
        normalyze_numer("abcone2threexyz".to_string())
    );
    assert_eq!(
        "234".to_string(),
        normalyze_numer("xtwone3four".to_string())
    );
    assert_eq!(
        "49872".to_string(),
        normalyze_numer("4nineeightseven2".to_string())
    );
    assert_eq!(
        "18234".to_string(),
        normalyze_numer("zoneight234".to_string())
    );
    assert_eq!(
        "76".to_string(),
        normalyze_numer("7pqrstsixteen".to_string())
    );
}
