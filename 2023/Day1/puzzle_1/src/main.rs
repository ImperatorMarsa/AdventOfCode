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
                        let calibration_value =
                            normalyze_numer(get_numbers_from_string(raw_calibration_value));

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

fn normalyze_numer(nubmer: String) -> String {
    match nubmer.chars().count() {
        0 => "".to_string(),
        1 => format!("{}{}", nubmer, nubmer),
        2 => nubmer,
        _ => {
            let (first_diget, other_digets) = nubmer.split_at(1);
            let (_, last_diget) = other_digets.split_at(other_digets.chars().count() - 1);

            format!("{}{}", first_diget, last_diget)
        }
    }
}
