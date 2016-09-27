class AddUserKeyToSurveys < ActiveRecord::Migration
  def change
    add_column :surveys, :user_key, :integer
  end
end
